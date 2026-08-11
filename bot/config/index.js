import dotenv from 'dotenv';
dotenv.config();

export const config = {
    apiUrl: process.env.API_URL || 'http://127.0.0.1:8000/api',
    sessionTimeoutMs: parseInt(process.env.REPORT_RESPONSE_TIMEOUT || '300000', 10), // Default 5 minutes
    appTimezone: process.env.APP_TIMEZONE || 'Asia/Jakarta'
};
