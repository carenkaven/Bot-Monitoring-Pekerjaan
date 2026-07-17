import dotenv from 'dotenv';
dotenv.config();

export const config = {
    apiUrl: process.env.API_URL || 'http://127.0.0.1:8000/api',
    sessionTimeoutMs: 30 * 60 * 1000 // 30 minutes
};
