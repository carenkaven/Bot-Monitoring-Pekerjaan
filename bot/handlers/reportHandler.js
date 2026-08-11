import { getSession, setSession, deleteSession, updateSessionTimeout, clearSessionTimeout } from '../services/session.js';
import { getProjects, saveLaporan } from '../api/laravel.js';
import { downloadMediaMessage } from '@whiskeysockets/baileys';
import { formatWIB } from '../utils/timezone.js';

export const handleReportWizard = async (sock, remoteJid, phone, messageText, msg) => {
    let session = getSession(phone);
    const cleanText = messageText.trim();
    const upperText = cleanText.toUpperCase();

    // Initial state
    if (!session) {
        session = { step: 0, data: {}, images: [] };
        console.log(`[SESSION] Started for ${phone} at ${formatWIB()}`);
    }

    const reply = async (text) => {
        await sock.sendMessage(remoteJid, { text }).catch(console.error);
        updateSessionTimeout(phone, session, sock, remoteJid);
    };

    switch (session.step) {
        case 0:
            // State: Mulai dan tanya proyek
            try {
                const projectsRes = await getProjects();
                const projects = projectsRes.data || projectsRes;
                let text = `Halo, selamat datang di Sistem Monitoring Laporan Proyek.\n\nSilakan isi laporan harian.\n\nKetik "BATAL" kapan saja untuk membatalkan proses.\n\n`;

                if (projects && projects.length > 0) {
                    text += `Pilih proyek:\n`;
                    projects.forEach((p, i) => {
                        text += `${i + 1}. ${p.name || p.nama_proyek || 'Proyek ' + (i + 1)}\n`;
                    });
                    text += `\nBalas dengan angka pilihan.`;

                    session.projects = projects;
                    session.step = 1;
                    await reply(text);
                } else {
                    text += `Saat ini tidak ada daftar proyek yang tersedia. Silakan hubungi Admin.`;
                    await sock.sendMessage(remoteJid, { text });
                    deleteSession(phone);
                }

            } catch (error) {
                console.error("Error fetching projects", error);
                await sock.sendMessage(remoteJid, { text: "Gagal mengambil daftar proyek. Coba beberapa saat lagi." });
                deleteSession(phone);
            }
            break;

        case 1:
            // State: Menerima proyek, kirim template
            const projectIndex = parseInt(cleanText) - 1;
            if (isNaN(projectIndex) || !session.projects[projectIndex]) {
                await reply("⚠️ Pilihan tidak tersedia.\n\nSilakan balas dengan nomor proyek yang valid.");
                return;
            }
            session.data.project_id = session.projects[projectIndex].id;
            session.data.project_name = session.projects[projectIndex].name || session.projects[projectIndex].nama_proyek;
            session.step = 2;

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
                    await reply("⚠️ Mohon pastikan format pesannya dicopy secara utuh dan terisi datanya (terutama Lokasi dan Uraian).");
                    return;
                }

                session.step = 3;
                await reply("📸 *DOKUMENTASI*\n\nSilakan kirim foto dokumentasi.");
            } catch (e) {
                console.error("Error parsing template:", e);
                await reply("⚠️ Mohon isi dengan format yang benar.");
            }
            break;

        case 3:
            // State: Menerima foto
            const isImage = msg.message?.imageMessage || (msg.message?.documentMessage && msg.message.documentMessage.mimetype.includes('image'));
            
            // Prioritas cek "Selesai Dokumentasi" by number first (fallback keyword Selesai/-)
            if (cleanText === '2' || upperText === 'SELESAI' || cleanText === '-') {
                if (!session.images || session.images.length === 0) {
                    await reply("⚠️ Anda belum mengirim foto apapun. Silakan kirim foto dokumentasi.");
                    return;
                }
                session.step = 4;
                await sendConfirmation(session, reply);
                return;
            }

            if (cleanText === '1') {
                await reply("Silakan kirim foto dokumentasi berikutnya.");
                return;
            }

            if (!isImage) {
                await reply("⚠️ Silakan kirim foto dokumentasi atau pilih menu berikut:\n\n1. Tambah Foto\n2. Selesai Dokumentasi");
                return;
            }

            const imageSize = msg.message.imageMessage?.fileLength || msg.message.documentMessage?.fileLength;
            if (imageSize && parseInt(imageSize) > (5 * 1024 * 1024)) {
                await reply("⚠️ Ukuran gambar maksimal 5 MB. Silakan kirim gambar lain.");
                return;
            }

            try {
                const buffer = await downloadMediaMessage(
                    msg,
                    'buffer',
                    {},
                    { logger: console }
                );

                if (!session.images) session.images = [];
                session.images.push({
                    buffer: buffer,
                    mimetype: msg.message.imageMessage?.mimetype || msg.message.documentMessage?.mimetype || 'image/jpeg'
                });

                console.log(`[PHOTO] Photo received from ${phone} at ${formatWIB()}`);
                await reply("✅ Foto berhasil diterima.\n\nPilih:\n\n1. Tambah Foto\n2. Selesai Dokumentasi\n\nBalas dengan angka pilihan.");
            } catch (error) {
                console.error("Failed downloading media", error);
                await reply("⚠️ Terjadi kesalahan membaca gambar. Silakan kirim ulang foto.");
            }
            break;

        case 4:
            // Konfirmasi simpan
            if (cleanText === '1') {
                clearSessionTimeout(phone);
                await sock.sendMessage(remoteJid, { text: "Menyimpan laporan Anda... Mohon tunggu." });
                try {
                    const dataToSave = { ...session.data };
                    // Hanya mengirim 1 foto karena API eksisting hanya support 1 untuk saat ini
                    // (Sesuai constraint: jangan mengubah arsitektur existing/db secara drastis)
                    const imageObj = session.images[0]; 
                    delete dataToSave.project_name;

                    await saveLaporan(dataToSave, imageObj.buffer, imageObj.mimetype);
                    console.log(`[REPORT] ${phone} report completed at ${formatWIB()}`);
                    
                    session.step = 6;
                    await reply("✅ *LAPORAN BERHASIL DISIMPAN*\n\nTerima kasih, laporan telah selesai.\n\nPilih:\n\n1. Buat Laporan Baru\n2. Selesai");
                } catch (error) {
                    console.error("Gagal simpan", error);
                    await sock.sendMessage(remoteJid, { text: "❌ Terjadi kesalahan saat menyimpan laporan.\n\nSilakan hubungi Admin." });
                    deleteSession(phone);
                }
            } else if (cleanText === '2') {
                session.step = 5;
                await reply("✏️ *EDIT LAPORAN*\n\nPilih data yang ingin diubah:\n\n1. Lokasi\n2. Tanggal\n3. Progress\n4. Uraian\n5. Pekerja\n6. Tukang\n7. Mandor\n8. Material\n9. Peralatan\n10. Cuaca\n11. Catatan\n12. Kembali ke Konfirmasi\n\nBalas dengan angka pilihan.");
            } else if (cleanText === '3') {
                deleteSession(phone);
                await sock.sendMessage(remoteJid, { text: "Proses pelaporan telah dibatalkan." });
            } else {
                await reply("⚠️ Pilihan tidak tersedia.\n\nPilih:\n1. Kirim Laporan\n2. Edit Laporan\n3. Batalkan");
            }
            break;

        case 5:
            // State: Menerima Pilihan Edit
            // Untuk kesederhanaan jika user memilih angka, kita minta mereka mengetikkan nilainya
            if (session.editFieldWait) {
                // Menyimpan hasil edit
                const field = session.editFieldWait;
                session.data[field] = cleanText;
                session.editFieldWait = null;
                session.step = 4;
                await sock.sendMessage(remoteJid, { text: `✅ Data ${field} berhasil diubah.` });
                await sendConfirmation(session, reply);
                return;
            }

            const editChoice = parseInt(cleanText);
            const fieldsMap = {
                1: 'lokasi', 2: 'tanggal', 3: 'progress', 4: 'uraian', 5: 'pekerja', 
                6: 'tukang', 7: 'mandor', 8: 'material', 9: 'peralatan', 10: 'cuaca', 11: 'catatan'
            };

            if (editChoice === 12) {
                session.step = 4;
                await sendConfirmation(session, reply);
                return;
            }

            if (fieldsMap[editChoice]) {
                session.editFieldWait = fieldsMap[editChoice];
                await reply(`Silakan masukkan nilai baru untuk *${fieldsMap[editChoice]}*:`);
            } else {
                await reply("⚠️ Pilihan tidak tersedia. Balas dengan angka 1-12.");
            }
            break;

        case 6:
            // Setelah laporan berhasil
            if (cleanText === '1') {
                // Laporan baru
                deleteSession(phone);
                const newSession = { step: 0, data: {}, images: [] };
                setSession(phone, newSession);
                await handleReportWizard(sock, remoteJid, phone, '', msg); // trigger step 0
            } else if (cleanText === '2') {
                // Selesai
                deleteSession(phone);
                await sock.sendMessage(remoteJid, { text: "Terima kasih telah menggunakan layanan kami." });
            } else {
                await reply("⚠️ Pilihan tidak tersedia.\n\n1. Buat Laporan Baru\n2. Selesai");
            }
            break;
    }
};

const sendConfirmation = async (session, reply) => {
    const dateDisplay = session.data.tanggal;
    const summary = `📋 *KONFIRMASI LAPORAN*\n\nProyek: ${session.data.project_name}\nLokasi: ${session.data.lokasi}\nTanggal: ${dateDisplay}\nProgress: ${session.data.progress}%\nUraian: ${session.data.uraian}\nFoto: ${session.images.length} file\n\nPilih:\n\n1. Kirim Laporan\n2. Edit Laporan\n3. Batalkan\n\nBalas dengan angka pilihan.`;
    await reply(summary);
};
