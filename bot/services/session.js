import NodeCache from 'node-cache';
import { config } from '../config/index.js';
import { formatWIB } from '../utils/timezone.js';

// Cache dengan TTL 30 menit sebagai backup dasar
export const sessionCache = new NodeCache({ stdTTL: 1800, checkperiod: 120 });

export const getSession = (phone) => {
    return sessionCache.get(phone);
};

export const setSession = (phone, data) => {
    sessionCache.set(phone, data);
};

export const clearSessionTimeout = (phone) => {
    const session = sessionCache.get(phone);
    if (session && session.timeoutId) {
        clearTimeout(session.timeoutId);
        session.timeoutId = null;
        sessionCache.set(phone, session);
    }
};

export const deleteSession = (phone) => {
    const session = sessionCache.get(phone);
    if (session && session.timeoutId) {
        clearTimeout(session.timeoutId);
    }
    sessionCache.del(phone);
    console.log(`[SESSION] Session cleared for ${phone} at ${formatWIB()}`);
};

/**
 * Update session with timeout
 */
export const updateSessionTimeout = (phone, session, sock, remoteJid) => {
    if (session.timeoutId) {
        clearTimeout(session.timeoutId);
    }
    
    session.timeoutId = setTimeout(async () => {
        console.log(`[TIMEOUT] ${phone} did not respond within 5 minutes at ${formatWIB()}`);
        deleteSession(phone);
        if (sock && remoteJid) {
            await sock.sendMessage(remoteJid, { text: "⏰ Waktu pengisian laporan telah berakhir karena tidak ada respons.\n\nSilakan kirim laporan kembali melalui menu utama." }).catch(console.error);
        }
    }, config.sessionTimeoutMs);

    setSession(phone, session);
};
