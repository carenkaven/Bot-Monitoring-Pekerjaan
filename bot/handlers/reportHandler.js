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
            // State: Menerima proyek, tanya lokasi
            const projectIndex = parseInt(messageText) - 1;
            if (isNaN(projectIndex) || !session.projects[projectIndex]) {
                await reply("Mohon balas dengan nomor proyek yang valid.");
                return;
            }
            session.data.project_id = session.projects[projectIndex].id;
            session.data.project_name = session.projects[projectIndex].name || session.projects[projectIndex].nama_proyek;
            session.step = 2;
            setSession(phone, session);
            await reply("2. Lokasi pekerjaan");
            break;

        case 2:
            // State: Menerima lokasi, tanya tanggal
            session.data.lokasi = messageText;
            session.step = 3;
            setSession(phone, session);
            await reply("3. Tanggal pekerjaan\n(Contoh: 2026-07-16)\nKirim '-' atau teks bebas jika ingin memakai default hari ini.");
            break;

        case 3:
            // State: Menerima tanggal, tanya progress
            session.data.tanggal = messageText === '-' ? new Date().toISOString().split('T')[0] : messageText;
            session.step = 4;
            setSession(phone, session);
            await reply("4. Progress pekerjaan (%)\n\n*Hanya angka 0-100");
            break;

        case 4:
            // State: Menerima progress, tanya uraian
            const progress = parseInt(messageText);
            if (isNaN(progress) || progress < 0 || progress > 100) {
                await reply("Mohon isi dengan angka yang valid (0-100).");
                return;
            }
            session.data.progress = progress;
            session.step = 5;
            setSession(phone, session);
            await reply("5. Uraian pekerjaan");
            break;

        case 5:
            // State: Menerima uraian, tanya jumlah pekerja
            session.data.uraian = messageText;
            session.step = 6;
            setSession(phone, session);
            await reply("6. Jumlah pekerja\n\n*Kirim angka saja");
            break;

        case 6:
            // State: Menerima pekerja, tanya tukang
            if (isNaN(parseInt(messageText))) {
                await reply("Mohon isi dengan angka."); return;
            }
            session.data.pekerja = parseInt(messageText);
            session.step = 7;
            setSession(phone, session);
            await reply("7. Jumlah tukang\n\n*Kirim angka saja");
            break;

        case 7:
            if (isNaN(parseInt(messageText))) {
                await reply("Mohon isi dengan angka."); return;
            }
            session.data.tukang = parseInt(messageText);
            session.step = 8;
            setSession(phone, session);
            await reply("8. Jumlah mandor\n\n*Kirim angka saja");
            break;

        case 8:
            if (isNaN(parseInt(messageText))) {
                await reply("Mohon isi dengan angka."); return;
            }
            session.data.mandor = parseInt(messageText);
            session.step = 9;
            setSession(phone, session);
            await reply("9. Material yang digunakan\n\n(Boleh dipisahkan koma. Contoh: Semen, Pasir, Batu)");
            break;

        case 9:
            session.data.material = messageText;
            session.step = 10;
            setSession(phone, session);
            await reply("10. Peralatan yang digunakan\n\n(Contoh: Concrete Mixer, Vibrator)");
            break;

        case 10:
            session.data.peralatan = messageText;
            session.step = 11;
            setSession(phone, session);
            await reply("11. Kondisi cuaca\n\nPilihan:\n- Cerah\n- Mendung\n- Hujan");
            break;

        case 11:
            const cuacaValid = ['cerah', 'mendung', 'hujan'].includes(messageText.toLowerCase().trim());
            if (!cuacaValid) {
                await reply("Mohon balas dengan salah satu dari: Cerah, Mendung, atau Hujan."); return;
            }
            session.data.cuaca = messageText;
            session.step = 12;
            setSession(phone, session);
            await reply("12. Catatan tambahan\n\n*Kirim '-' untuk mengosongkan");
            break;

        case 12:
            session.data.catatan = messageText === '-' ? '' : messageText;
            session.step = 13;
            setSession(phone, session);
            await reply("13. Upload foto pekerjaan\n\n*Mohon kirimkan satu file gambar (maksimal 5 MB)");
            break;

        case 13:
            // State: Menerima foto
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
                // Download gambar masuk ke buffer
                const buffer = await downloadMediaMessage(
                    msg,
                    'buffer',
                    { },
                    { 
                        logger: console,
                        // pastikan reupload logic kalau butuh, standard buffer return 
                    }
                );
                
                session.data.gambar = buffer;
                session.data.mimetype = msg.message.imageMessage?.mimetype || 'image/jpeg';
                session.step = 14;
                setSession(phone, session);

                // Show summary
                const dateDisplay = session.data.tanggal; // formatting default
                const summary = `===== LAPORAN HARIAN =====\n\nProyek :\n${session.data.project_name}\n\nLokasi :\n${session.data.lokasi}\n\nTanggal :\n${dateDisplay}\n\nProgress :\n${session.data.progress}%\n\nPekerja :\n${session.data.pekerja}\n\nTukang :\n${session.data.tukang}\n\nMandor :\n${session.data.mandor}\n\nMaterial :\n${session.data.material}\n\nPeralatan :\n${session.data.peralatan}\n\nCuaca :\n${session.data.cuaca}\n\nCatatan :\n${session.data.catatan || 'Tidak ada kendala.'}\n\n=====================\n\nKetik:\n\nYA\n\nuntuk menyimpan\n\natau\n\nBATAL\n\nuntuk membatalkan.`;
                await reply(summary);
            } catch (error) {
                console.error("Failed downloading media", error);
                await reply("Terjadi kesalahan membaca gambar. Silakan kirim ulang foto.");
            }
            
            break;

        case 14:
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
