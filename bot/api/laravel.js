import axios from 'axios';
import { config } from '../config/index.js';
import FormData from 'form-data';

const apiClient = axios.create({
    baseURL: config.apiUrl,
    headers: {
        'Accept': 'application/json',
    }
});

export const checkPhone = async (phone) => {
    try {
        const response = await apiClient.get(`/check-phone/${phone}`);
        return response.data;
    } catch (error) {
        throw error;
    }
};

export const getProjects = async () => {
    try {
        const response = await apiClient.get('/projects');
        return response.data;
    } catch (error) {
        throw error;
    }
};

export const saveLaporan = async (laporanData, imageBuffer, mimetype) => {
    try {
        const form = new FormData();
        Object.keys(laporanData).forEach(key => {
            if (laporanData[key] !== undefined && laporanData[key] !== null) {
                form.append(key, laporanData[key]);
            }
        });
        
        if (imageBuffer) {
            const ext = mimetype.split('/')[1] || 'img';
            form.append('foto', imageBuffer, { filename: `foto_${Date.now()}.${ext}` });
        }

        const response = await apiClient.post('/laporan', form, {
            headers: {
                ...form.getHeaders()
            }
        });
        return response.data;
    } catch (error) {
        throw error;
    }
};
