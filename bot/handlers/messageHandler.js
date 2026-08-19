import { handleReportWizard } from './reportHandler.js';
import { deleteSession, getSession, clearSessionTimeout } from '../services/session.js';
import { formatWIB } from '../utils/timezone.js';

export const handleIncomingMessage = async (sock, m) => {
    try {
        const msg = m.messages[0];
        if (!msg.message) return; // Allow fromMe for self-testing

        const remoteJid = msg.key.remoteJid;

        // Skip pesan dari grup
        if (remoteJid.endsWith('@g.us')) return;

        const phone = remoteJid.split('@')[0];

        // Ambil isi teks (Support Disappearing Messages / Ephemeral)
        const msgBody = msg.message;
        let messageText = msgBody?.conversation || 
                          msgBody?.extendedTextMessage?.text || 
                          msgBody?.ephemeralMessage?.message?.extendedTextMessage?.text ||
                          msgBody?.ephemeralMessage?.message?.conversation ||
                          msgBody?.imageMessage?.caption ||
                          msgBody?.ephemeralMessage?.message?.imageMessage?.caption ||
                          '';

        const cleanText = messageText.trim();
        const upperText = cleanText.toUpperCase();
        const isInSession = !!getSession(phone);

        // Fallback global cancel
        if (upperText === 'BATAL' || upperText === 'CANCEL') {
            if (isInSession) {
                deleteSession(phone);
                await sock.sendMessage(remoteJid, { text: "Proses pelaporan telah dibatalkan." });
            }
            return;
        }

        // Jika dalam session laporan, lewati menu utama
        if (isInSession) {
            clearSessionTimeout(phone);
            console.log(`[RESPONSE] ${phone} responded at ${formatWIB()}`);
            await handleReportWizard(sock, remoteJid, phone, cleanText, msg);
            return;
        }

        // EXACT MATCH untuk menu utama
        if (cleanText === '1' || upperText === 'LAPOR') {
            await handleReportWizard(sock, remoteJid, phone, cleanText, msg);
            return;
        }

        if (cleanText === '2' || upperText === 'STATUS') {
            await sock.sendMessage(remoteJid, { text: "Fitur cek riwayat/status laporan segera hadir." });
            return;
        }

        if (cleanText === '3' || upperText === 'BANTUAN') {
            await sock.sendMessage(remoteJid, {
                text: "📋 *BANTUAN*\n\nGunakan pilihan angka untuk navigasi:\n1. Buat Laporan Harian : Memulai pelaporan.\n2. Riwayat Laporan : Cek status.\n3. Bantuan : Menampilkan panduan ini.\n\nKetik 'BATAL' kapan saja jika ingin membatalkan proses laporan berjalan."
            });
            return;
        }

        if (['TEST', 'PING', 'HALO', 'HAI', 'P', 'MENU'].includes(upperText)) {
            await sock.sendMessage(remoteJid, { 
                text: "Halo! 🤖 Bot WhatsApp Monitoring PKN aktif.\n\n📋 *MENU UTAMA*\n\nSilakan pilih:\n\n1. Buat Laporan Harian\n2. Lihat Riwayat Laporan\n3. Bantuan\n\nBalas dengan angka pilihan." 
            });
            return;
        }

        // Tampilkan Menu Utama jika tidak dikenali
        await sock.sendMessage(remoteJid, { 
            text: "📋 *MENU UTAMA*\n\nSilakan pilih:\n\n1. Buat Laporan Harian\n2. Lihat Riwayat Laporan\n3. Bantuan\n\nBalas dengan angka pilihan." 
        });

    } catch (error) {
        console.error("Message Handler Error: ", error);
    }
};
