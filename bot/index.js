import { connectToWhatsApp } from './services/whatsapp.js';

console.log("Starting WhatsApp Bot...");
connectToWhatsApp().catch(err => console.log("Failed to start bot", err));
