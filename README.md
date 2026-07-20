# 🚧 Bot Monitoring Pekerjaan & Laporan (PT Reno)

Sebuah sistem aplikasi berbasis **Laravel** yang mengintegrasikan Web Dashboard (Admin & Karyawan) dengan **WhatsApp Bot Interaktif** menggunakan **API Fonnte**. Proyek ini dirancang untuk memudahkan para pekerja lapangan dalam membuat laporan harian & progres proyek secara langsung dari WhatsApp, yang kemudian tersinkronisasi otomatis ke sistem pusat.

## ✨ Fitur Utama

### 1. Web Dashboard (Admin)
- **Manajemen Karyawan:** Tambah, edit, dan atur status akses pekerja/karyawan.
- **Monitoring Laporan:** Tinjau seluruh laporan harian yang masuk secara *real-time*.
- **Verifikasi Laporan:** Admin dapat menyetujui, menolak, hingga menghapus laporan yang masuk.
- **Export PDF:** Cetak *invoice* / rekapitulasi harian laporan pekerja secara rapi dalam bentuk dokumen PDF.

### 2. WhatsApp Bot Fonnte (2-Langkah)
- **Menu Utama:** Navigasi interaktif berbasis angka (1 untuk *Lapor*, 2 untuk *Status*, 3 untuk *Bantuan*).
- **Lapor Harian Cepat (2 Langkah):**
  1. Ketik `LAPOR` → Bot mengirimkan template isian lengkap → User copy, isi, lalu kirim kembali dalam **1 pesan**.
  2. Bot meminta **foto dokumentasi** → User kirim foto → **Selesai!** ✅
- **Unggah Foto Dokumentasi Laporan** (Khusus Pengguna Akun Fonnte Paket `Super/Advanced/Ultra`).

---

## 💻 Panduan Instalasi (Development Lokal)

### Persyaratan Sistem
- **PHP** ^8.1
- **Composer**
- **Node.js** & **NPM**
- Akun & Token **Fonnte API** (Aktifkan Webhook & Auto Read)
- **Ngrok** (Untuk meneruskan lalu lintas jaringan *Localhost* ke IP Publik)
- Database **MySQL** / MariaDB

### Langkah-langkah

1. **Kloning Proyek**
   ```bash
   git clone https://github.com/carenkaven/Bot-Monitoring-Pekerjaan.git
   cd Bot-Monitoring-Pekerjaan
   ```

2. **Install Dependensi**
   ```bash
   composer install
   npm install
   ```

3. **Konfigurasi Lingkungan (.env)**
   File `.env` sudah tersedia di repositori ini. Buka file `.env` dan sesuaikan variabel berikut jika diperlukan:
   ```env
   DB_DATABASE=db_monitoring_laporanpkn
   DB_USERNAME=root
   DB_PASSWORD=

   FONNTE_TOKEN=TOKEN_DARI_DASHBOARD_FONNTE_ANDA
   ```

4. **Generate App Key & Konfigurasi Basis Data**
   ```bash
   php artisan key:generate
   php artisan migrate
   php artisan storage:link
   ```

5. **Seeder (Opsional, untuk data awal & akun admin)**
   ```bash
   php artisan db:seed
   ```

---

## 🚀 Menjalankan Aplikasi

Cukup jalankan **satu perintah** saja di terminal:

```bash
php artisan start
```

Perintah ini akan otomatis menjalankan **3 layanan sekaligus**:

| Layanan | Fungsi |
|---------|--------|
| **Laravel Server** | Backend website di `http://localhost:8000` |
| **Vite** | Compile frontend (Tailwind CSS & JS) |
| **Ngrok** | Tunnel publik supaya Fonnte bisa kirim webhook ke laptop Anda |

> **Catatan:** Bot WhatsApp dijalankan melalui **Fonnte (cloud)**, jadi tidak perlu dijalankan manual. Cukup pastikan webhook Fonnte sudah diatur ke URL Ngrok yang benar.

Tekan `Ctrl+C` untuk menghentikan semua layanan sekaligus.

---

## 🔗 Panduan Menyambungkan Webhook Fonnte

1. Jalankan `php artisan start` (Ngrok otomatis ikut jalan).
2. Lihat URL Ngrok di terminal (contoh: `https://abcd-123.ngrok-free.dev`).
3. Buka **Dashboard Fonnte** -> **Device**.
4. Isi kolom **Webhook** dengan:
   ```text
   https://abcd-123.ngrok-free.dev/api/whatsapp/fonnte
   ```
5. Pastikan **Auto Read = ON** di dashboard Fonnte.

> ⚠️ **Penting:** URL Ngrok dapat berubah setiap kali Ngrok dijalankan ulang (khusus akun gratisan). Jika URL berubah, update juga di dashboard Fonnte.

---

## 📱 Format Pelaporan WhatsApp (2 Langkah)

### Langkah 1: Kirim Teks
Ketik `LAPOR` ke nomor bot WhatsApp. Bot akan membalas dengan template. Copy, isi, dan kirim kembali dalam **1 pesan**:

```
Nama Proyek: Pembangunan Jalan Lingkar
Kegiatan: Pekerjaan Beton
Sub Kegiatan: Rigid Pavement
Pekerjaan: Pengecoran
Lokasi: Jl. Raya Tlogomas
Kontraktor: PT ABC
Konsultan: CV XYZ
Minggu Ke: 1
Tenaga: pekerja=8, tukang=4, mandor=1, pelaksana=1
Material: Semen|20|sak; Pasir|3|m3
Alat: Concrete Mixer|1; Vibrator|2
Catatan: Cuaca cerah
```

### Langkah 2: Kirim Foto
Setelah teks diterima, bot akan meminta **1 foto dokumentasi**. Kirim foto, dan laporan langsung tersimpan!

---

## 🔒 Default Kredensial Login

Untuk mengakses dashboard Web Admin, gunakan kredensial default berikut atau lihat file `CREDENTIALS.md`:

| Field | Value |
|-------|-------|
| Email | `admin@monitoring.com` |
| Password | `password123` |
| Role | Admin |

---

> ©️ 2026 PT Reno Abirama Sakti - Dikembangkan untuk kebutuhan operasional monitoring lapangan.
