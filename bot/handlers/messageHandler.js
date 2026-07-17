import { handleReportWizard } from './reportHandler.js';
import { deleteSession, getSession } from '../services/session.js';

export const handleIncomingMessage = async (sock, m) => {
    try {
        const msg = m.messages[0];
        if (!msg.message || msg.key.fromMe) return;

        const remoteJid = msg.key.remoteJid;

        // Skip pesan dari grup
        if (remoteJid.endsWith('@g.us')) return;

        const phone = remoteJid.split('@')[0];

        // Ambil isi teks
        const messageType = Object.keys(msg.message)[0];
        const isImage = messageType === 'imageMessage';

        let messageText = '';
        if (messageType === 'conversation') {
            messageText = msg.message.conversation;
        } else if (messageType === 'extendedTextMessage') {
            messageText = msg.message.extendedTextMessage.text;
        } else if (isImage) {
            messageText = msg.message.imageMessage?.caption || '';
        }

        const cleanText = messageText.trim();
        const upperText = cleanText.toUpperCase();
        const isInSession = !!getSession(phone);

        // Batal - cancel session aktif
        if (upperText === 'BATAL') {
            if (isInSession) {
                deleteSession(phone);
                await sock.sendMessage(remoteJid, { text: "Proses pelaporan telah dibatalkan." });
            }
            return;
        }

        // Bantuan
        if (upperText === 'BANTUAN') {
            await sock.sendMessage(remoteJid, {
                text: "Perintah yang tersedia:\n1. LAPOR : Memulai pelaporan.\n2. STATUS : Status laporan.\n3. BANTUAN : Bantuan perintah.\n4. BATAL : Membatalkan proses."
            });
            return;
        }

        if (upperText === 'STATUS') {
            await sock.sendMessage(remoteJid, { text: "Fitur cek status laporan segera hadir." });
            return;
        }

        if (['TEST', 'PING', 'HALO', 'HAI', 'P'].includes(upperText)) {
            await sock.sendMessage(remoteJid, { text: "Halo! Bot WhatsApp Monitoring PKN aktif. 🤖✅" });
            return;
        }

        // Masuk ke wizard pelaporan
        if (upperText === 'LAPOR' || isInSession) {
            await handleReportWizard(sock, remoteJid, phone, cleanText, msg);
            return;
        }

    } catch (error) {
        console.error("Message Handler Error: ", error);
    }
};
