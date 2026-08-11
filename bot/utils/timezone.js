/**
 * Utility functions for handling timestamps in Asia/Jakarta (WIB) timezone
 */

/**
 * Mendapatkan representasi Date saat ini di zona waktu WIB.
 * Ini berguna ketika kita ingin menyimpan timestamp yang akurat secara display.
 */
export const nowWIB = () => {
    // Kita membuat objek Date baru berdasarkan string representation di WIB
    const wibString = new Date().toLocaleString("en-US", { timeZone: "Asia/Jakarta" });
    return new Date(wibString);
};

/**
 * Format Date ke string dengan gaya "10 Aug 2026 22:30:15 WIB"
 * Menerima optional argumen date, jika tidak ada, gunakan waktu sekarang.
 */
export const formatWIB = (date = new Date()) => {
    const formatter = new Intl.DateTimeFormat('en-GB', {
        timeZone: 'Asia/Jakarta',
        day: '2-digit',
        month: 'short',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit',
        hour12: false
    });
    
    // Format menghasilkan string seperti "10 Aug 2026, 22:30:15"
    // Kita hilangkan koma dan tambahkan " WIB"
    const formattedParts = formatter.formatToParts(date);
    
    const day = formattedParts.find(p => p.type === 'day').value;
    const month = formattedParts.find(p => p.type === 'month').value;
    const year = formattedParts.find(p => p.type === 'year').value;
    const hour = formattedParts.find(p => p.type === 'hour').value;
    const minute = formattedParts.find(p => p.type === 'minute').value;
    const second = formattedParts.find(p => p.type === 'second').value;

    return `${day} ${month} ${year} ${hour}:${minute}:${second} WIB`;
};

/**
 * Format Date ke YYYY-MM-DD string di WIB
 */
export const formatDateWIB = (date = new Date()) => {
    const formatter = new Intl.DateTimeFormat('en-GB', {
        timeZone: 'Asia/Jakarta',
        day: '2-digit',
        month: '2-digit',
        year: 'numeric',
    });
    
    const formattedParts = formatter.formatToParts(date);
    const day = formattedParts.find(p => p.type === 'day').value;
    const month = formattedParts.find(p => p.type === 'month').value;
    const year = formattedParts.find(p => p.type === 'year').value;

    return `${year}-${month}-${day}`;
};
