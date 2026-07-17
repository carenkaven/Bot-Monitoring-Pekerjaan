import NodeCache from 'node-cache';
import { config } from '../config/index.js';

// Cache dengan TTL 30 menit (1800 detik)
export const sessionCache = new NodeCache({ stdTTL: config.sessionTimeoutMs / 1000, checkperiod: 120 });

/**
 * Get user session
 * @param {string} phone 
 */
export const getSession = (phone) => {
    return sessionCache.get(phone);
};

/**
 * Set user session
 * @param {string} phone 
 * @param {object} data state percakapan
 */
export const setSession = (phone, data) => {
    sessionCache.set(phone, data);
};

/**
 * Delete session 
 * @param {string} phone 
 */
export const deleteSession = (phone) => {
    sessionCache.del(phone);
};
