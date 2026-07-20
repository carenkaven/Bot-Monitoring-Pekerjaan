import { getSession, setSession, deleteSession } from '../services/session.js';
import { getProjects, saveLaporan } from '../api/laravel.js';
import { downloadMediaMessage } from '@whiskeysockets/baileys';

/**
 * Handle report wizard
 * @param {import('@whiskeysockets/baileys').WASocket} sock 
 * @param {string} remoteJid 
 * @param {string} phone 
 * @param {string} messageText 
 * @param {object} msg Object original pesan untuk extrak gambar
 */
export const handleReportWizard = async (sock, remoteJid, phone, messageText, msg) => {
    let session = getSession(phone);

    // Initial state
    if (!session) {
        session = { step: 0, data: {} };
        setSession(phone, session);
    }

    const reply = async (text) => {
        await sock.sendMessage(remoteJid, { text });
    };

    switch (session.step) {
        case 0:
            // State: Mulai dan tanya proyek
            try {
                const projectsRes = await getProjects();
                const projects = projectsRes.data || projectsRes; // adaptasi ke format api
                let text = `Halo, selamat datang di Sistem Monitoring Laporan Proyek.\n\nSilakan isi laporan harian.\n\nKetik "BATAL" kapan saja untuk membatalkan proses.\n\n`;
                
                if (projects && projects.length > 0) {
                    text += `1. Pilih proyek:\n`;
                    projects.forEach((p, i) => {
                        text += `${i + 1}. ${p.name || p.nama_proyek || 'Proyek ' + (i+1)}\n`;
                    });
                    text += `\nBalas dengan nomor proyek.`;
                    
                    session.projects = projects; // simpan referensi
                    session.step = 1;
                    setSession(phone, session);
                } else {
                    text += `Saat ini tidak ada daftar proyek yang tersedia. Silakan hubungi Admin.`;
                    deleteSession(phone);
                }
                await reply(text);
                
            } catch (error) {
                console.error("Error fetching projects", error);
                await reply("Gagal mengambil daftar proyek. Coba beberapa saat lagi.");
                deleteSession(phone);
            }
            break;

        case 1:
            // State: Menerima proyek, kirim template
            const projectIndex = parseInt(messageText) - 1;
            if (isNaN(projectIndex) || !session.projects[projectIndex]) {
                await reply("Mohon balas dengan nomor proyek yang valid.");
                return;
            }
            session.data.project_id = session.projects[projectIndex].id;
            session.data.project_name = session.projects[projectIndex].name || session.projects[projectIndex].nama_proyek;
            session.step = 2;
            setSession(phone, session);
            
            const template = `Silakan copy format di bawah ini dan lengkapi datanya:\n\nLokasi: \nTanggal (YYYY-MM-DD): \nProgress (%): \nUraian: \nJumlah Pekerja: \nJumlah Tukang: \nJumlah Mandor: \nMaterial: \nPeralatan: \nCuaca (Cerah/Mendung/Hujan): \nCatatan: \n`;
            await reply(template);
            break;

        case 2:
            // State: Menerima template, parse data, tanya foto
            try {
                const val = (key) => {
                    const regex = new RegExp(`(?<=${key}:\\s*)(.*)`, 'i');
                    const match = messageText.match(regex);
                    return match ? match[1].trim() : '';
                };
                
                session.data.lokasi = val('Lokasi');
                let tgl = val('Tanggal \\(YYYY-MM-DD\\)') || val('Tanggal');
                session.data.tanggal = tgl === '-' || !tgl ? new Date().toISOString().split('T')[0] : tgl;
                session.data.progress = parseInt(val('Progress \\(%\\)') || val('Progress')) || 0;
                session.data.uraian = val('Uraian');
                session.data.pekerja = parseInt(val('Jumlah Pekerja')) || 0;
                session.data.tukang = parseInt(val('Jumlah Tukang')) || 0;
                session.data.mandor = parseInt(val('Jumlah Mandor')) || 0;
                session.data.material = val('Material');
                session.data.peralatan = val('Peralatan');
                
                let cuaca = val('Cuaca \\(Cerah/Mendung/Hujan\\)') || val('Cuaca');
                cuaca = cuaca.toLowerCase().trim();
                const cuacaValid = ['cerah', 'mendung', 'hujan'].includes(cuaca);
                session.data.cuaca = cuacaValid ? cuaca : 'cerah';
                
                session.data.catatan = val('Catatan');

                if (!session.data.lokasi || !session.data.uraian) {
                    await reply("Mohon pastikan format pesannya dicopy secara utuh dan terisi datanya (terutama Lokasi dan Uraian).");
                    return;
                }

                session.step = 3;
                setSession(phone, session);
                await reply("Mohon kirimkan file gambar/foto pekerjaan (maksimal 5 MB).");
            } catch (e) {
                console.error("Error parsing template:", e);
                await reply("Mohon isi dengan format yang benar.");
            }
            break;

        case 3:
            // State: Menerima foto, kirim summary
            const isImage = msg.message?.imageMessage || (msg.message?.documentMessage && msg.message.documentMessage.mimetype.includes('image'));
            if (!isImage) {
                await reply("Mohon kirim file berupa gambar.");
                return;
            }
            
            const imageSize = msg.message.imageMessage?.fileLength || msg.message.documentMessage?.fileLength;
            if (imageSize && parseInt(imageSize) > (5 * 1024 * 1024)) {
                await reply("Ukuran gambar maksimal 5 MB.");
                return;
            }

            try {
                const buffer = await downloadMediaMessage(
                    msg,
                    'buffer',
                    { },
                    { logger: console }
                );
                
                session.data.gambar = buffer;
                session.data.mimetype = msg.message.imageMessage?.mimetype || msg.message.documentMessage?.mimetype || 'image/jpeg';
                session.step = 4;
                setSession(phone, session);

                // Show summary
                const dateDisplay = session.data.tanggal; 
                const summary = `===== LAPORAN HARIAN =====\n\nProyek :\n${session.data.project_name}\n\nLokasi :\n${session.data.lokasi}\n\nTanggal :\n${dateDisplay}\n\nProgress :\n${session.data.progress}%\n\nPekerja :\n${session.data.pekerja}\n\nTukang :\n${session.data.tukang}\n\nMandor :\n${session.data.mandor}\n\nMaterial :\n${session.data.material}\n\nPeralatan :\n${session.data.peralatan}\n\nCuaca :\n${session.data.cuaca}\n\nCatatan :\n${session.data.catatan || 'Tidak ada kendala.'}\n\n=====================\n\nKetik:\n\nYA\n\nuntuk menyimpan\n\natau\n\nBATAL\n\nuntuk membatalkan.`;
                await reply(summary);
            } catch (error) {
                console.error("Failed downloading media", error);
                await reply("Terjadi kesalahan membaca gambar. Silakan kirim ulang foto.");
            }
            break;

        case 4:
            // Konfirmasi simpan
            if (messageText.toUpperCase().trim() === 'YA') {
                await reply("Menyimpan laporan Anda... Mohon tunggu.");
                try {
                    const dataToSave = { ...session.data };
                    const buffer = dataToSave.gambar;
                    const mime = dataToSave.mimetype;
                    delete dataToSave.gambar;
                    delete dataToSave.mimetype;
                    delete dataToSave.project_name;
                    
                    await saveLaporan(dataToSave, buffer, mime);
                    await reply("✅ Laporan berhasil disimpan.\n\nTerima kasih.");
                } catch (error) {
                    console.error("Gagal simpan", error);
                    await reply("❌ Terjadi kesalahan saat menyimpan laporan.\n\nSilakan coba kembali.");
                }
                deleteSession(phone);
            } else if (messageText.toUpperCase().trim() === 'BATAL') {
                deleteSession(phone);
                await reply("Proses pelaporan telah dibatalkan.");
            } else {
                await reply("Silakan ketik YA untuk menyimpan atau BATAL untuk membatalkan.");
            }
            break;
    }
};
