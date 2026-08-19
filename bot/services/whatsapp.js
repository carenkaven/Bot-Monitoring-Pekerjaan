import { makeWASocket, useMultiFileAuthState, DisconnectReason, Browsers, fetchLatestBaileysVersion } from '@whiskeysockets/baileys';
import { handleIncomingMessage } from '../handlers/messageHandler.js';
import Pino from 'pino';
import fs from 'fs';
import path from 'path';

const AUTH_DIR = path.resolve('./auth_info_baileys');
const QR_PATH = path.resolve('./storage/app/whatsapp-qr.txt');
const PHONE = (process.env.WA_PHONE_NUMBER || '').replace(/\D/g, '');

const logger = Pino({ level: 'silent' });

// ─── Helper: hapus sesi lama ──────────────────────────────────────────────────
function clearSession() {
    if (fs.existsSync(AUTH_DIR)) {
        fs.rmSync(AUTH_DIR, { recursive: true, force: true });
    }
    if (fs.existsSync(QR_PATH)) {
        fs.unlinkSync(QR_PATH);
    }
}

// ─── Fungsi utama koneksi ─────────────────────────────────────────────────────
export const connectToWhatsApp = async (isReconnect = false) => {
    if (!isReconnect) {
        console.log('🟡 Memulai sesi WhatsApp (memuat sesi lama jika ada)...');
    }

    if (!PHONE) {
        console.error('❌ WA_PHONE_NUMBER belum diisi di file .env!');
        console.error('   Buka file .env, isi: WA_PHONE_NUMBER=628xxxxxxxxxx');
        console.error('   Contoh: WA_PHONE_NUMBER=628123456789');
        process.exit(1);
    }

    const { state, saveCreds } = await useMultiFileAuthState(AUTH_DIR);

    const { version } = await fetchLatestBaileysVersion();

    const sock = makeWASocket({
        version,
        logger,
        printQRInTerminal: true,
        auth: state,
    });

    // ─── Pairing Code (Dinonaktifkan karena WhatsApp memblokir dengan kode 405) ──
    // Silakan scan QR code yang muncul di terminal

    // ─── Event: status koneksi ────────────────────────────────────────────────
    sock.ev.on('connection.update', async (update) => {
        const { connection, lastDisconnect, qr } = update;
        
        if (qr) {
            console.log('📝 Menyimpan QR Code ke file untuk web...');
            fs.writeFileSync(QR_PATH, qr);
        }

        if (connection === 'open') {
            if (fs.existsSync(QR_PATH)) fs.unlinkSync(QR_PATH);
            console.log('✅ WhatsApp Bot AKTIF! Siap menerima pesan.');
        }

        if (connection === 'close') {
            const code = lastDisconnect?.error?.output?.statusCode;
            const isLoggedOut = code === DisconnectReason.loggedOut;
            console.log(`⚠️  Koneksi terputus (kode: ${code ?? 'unknown'})`);

            if (isLoggedOut) {
                console.log('🚪 Sesi logout. Memulai ulang...');
                clearSession();
                setTimeout(() => connectToWhatsApp(false), 2000);
            } else {
                console.log('🔄 Reconnecting in 3s...');
                setTimeout(() => connectToWhatsApp(true), 3000); // Delay before reconnect
            }
        }
    });

    sock.ev.on('creds.update', saveCreds);

    sock.ev.on('messages.upsert', async m => {
        if (m.type === 'notify') {
            await handleIncomingMessage(sock, m);
        }
    });
};

