import { makeWASocket, useMultiFileAuthState, DisconnectReason } from '@whiskeysockets/baileys';
import { handleIncomingMessage } from '../handlers/messageHandler.js';
import Pino from 'pino';
import fs from 'fs';
import path from 'path';

const AUTH_DIR   = path.resolve('./auth_info_baileys');
const QR_PATH    = path.resolve('./storage/app/whatsapp-qr.txt');
const PHONE      = (process.env.WA_PHONE_NUMBER || '').replace(/\D/g, '');

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
        // Hapus sesi rusak setiap kali pertama kali start
        clearSession();
        console.log('🟡 Memulai sesi WhatsApp baru...');
    }

    if (!PHONE) {
        console.error('❌ WA_PHONE_NUMBER belum diisi di file .env!');
        console.error('   Buka file .env, isi: WA_PHONE_NUMBER=628xxxxxxxxxx');
        console.error('   Contoh: WA_PHONE_NUMBER=628123456789');
        process.exit(1);
    }

    const { state, saveCreds } = await useMultiFileAuthState(AUTH_DIR);

    const sock = makeWASocket({
        logger,
        printQRInTerminal: false,
        auth: state,
        browser: ['Monitoring PKN', 'Chrome', '120.0.0'],
    });

    // ─── Pairing Code (hanya jika belum terdaftar) ────────────────────────────
    if (!sock.authState.creds.registered) {
        try {
            console.log(`📲 Meminta pairing code untuk nomor: ${PHONE}`);
            // Tunggu sebentar agar socket siap
            await new Promise(r => setTimeout(r, 2000));

            const code = await sock.requestPairingCode(PHONE);
            const formatted = code?.match(/.{1,4}/g)?.join('-') ?? code;

            console.log('\n╔══════════════════════════════════╗');
            console.log('║   KODE PAIRING WHATSAPP          ║');
            console.log(`║         ${(formatted ?? '').padEnd(26)}║`);
            console.log('╚══════════════════════════════════╝');
            console.log('\n📋 Cara pairing:');
            console.log('   1. Buka WhatsApp di HP');
            console.log('   2. Titik tiga (⋮) → Perangkat Tertaut');
            console.log('   3. Tautkan Perangkat → Tautkan dengan Nomor Telepon');
            console.log(`   4. Masukkan kode: ${formatted ?? '-'}\n`);
        } catch (err) {
            console.error('❌ Gagal minta pairing code:', err.message);
            // Coba lagi setelah 5 detik
            console.log('🔄 Mencoba ulang dalam 5 detik...');
            await new Promise(r => setTimeout(r, 5000));
            clearSession();
            return connectToWhatsApp(false);
        }
    }

    // ─── Event: status koneksi ────────────────────────────────────────────────
    sock.ev.on('connection.update', async (update) => {
        const { connection, lastDisconnect } = update;

        if (connection === 'open') {
            if (fs.existsSync(QR_PATH)) fs.unlinkSync(QR_PATH);
            console.log('✅ WhatsApp Bot AKTIF! Siap menerima pesan.');
        }

        if (connection === 'close') {
            const code = lastDisconnect?.error?.output?.statusCode;
            const isLoggedOut = code === DisconnectReason.loggedOut;
            console.log(`⚠️  Koneksi terputus (kode: ${code ?? 'unknown'})`);

            if (isLoggedOut) {
                console.log('🚪 Sesi logout. Memulai ulang dengan pairing baru...');
                clearSession();
                await connectToWhatsApp(false);
            } else {
                console.log('🔄 Reconnecting...');
                await connectToWhatsApp(true); // Reconnect tanpa clear sesi
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

