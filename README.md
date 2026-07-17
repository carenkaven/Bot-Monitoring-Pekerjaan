# 🚧 Bot Monitoring Pekerjaan & Laporan (PT Reno)

Sebuah sistem aplikasi berbasis **Laravel 10** yang mengintegrasikan Web Dashboard (Admin & Karyawan) dengan **WhatsApp Bot Interaktif** menggunakan **API Fonnte**. Proyek ini dirancang untuk memudahkan para pekerja lapangan dalam membuat laporan harian & progres proyek secara langsung dari WhatsApp, yang kemudian tersinkronisasi otomatis ke sistem pusat.

## ✨ Fitur Utama

### 1. Web Dashboard (Admin)
- **Manajemen Karyawan:** Tambah, edit, dan atur status akses pekerja/karyawan.
- **Monitoring Laporan:** Tinjau seluruh laporan harian yang masuk secara *real-time*.
- **Verifikasi Laporan:** Admin dapat menyetujui, menolak, hingga menghapus laporan yang masuk.
- **Export PDF:** Cetak *invoice* / rekapitulasi harian laporan pekerja secara rapi dalam bentuk dokumen PDF.

### 2. WhatsApp Bot Fonnte (Interactive Wizard)
- **Menu Utama:** Navigasi interaktif berbasis angka (1 untuk *Lapor*, 2 untuk *Status*, 3 untuk *Bantuan*).
- **Lapor Harian Terdorong (Stateful):** Alur laporan dengan menanyakan tiap poin-poin secara terurut:
  - *Identitas Proyek & Lokasi*
  - *Kegiatan & Sub Kegiatan*
  - *Daftar Tenaga, Alat, & Material*
  - *Catatan*
  - **Unggah Foto Dokumentasi Laporan** (Khusus Pengguna Akun Fonnte Paket `Super/Advanced/Ultra`).

---

## 💻 Panduan Instalasi (Development Lokal)

Agar sistem dapat berjalan sempurna di laptop/komputer lain, ikuti panduan instalasi berikut dengan teliti.

### Persyaratan Sistem
- **PHP** ^8.1
- **Composer**
- Akun & Token **Fonnte API** (Aktifkan Webhook & Auto Read)
- **Ngrok** (Untuk meneruskan lalu lintas jaringan *Localhost* ke IP Publik)
- Database **MySQL** / MariaDB

### Langkah-langkah

1. **Kloning Proyek**
   ```bash
   git clone https://github.com/carenkaven/Bot-Monitoring-Pekerjaan.git
   cd Bot-Monitoring-Pekerjaan
   ```

2. **Install Dependensi Laravel**
   ```bash
   composer install
   ```

3. **Konfigurasi Lingkungan (.env)**
   Duplikat file `.env.example` dan ubah nama menjadi `.env`.
   ```bash
   cp .env.example .env
   ```
   **PENTING!** Buka file `.env` dan tambahkan / ubah variabel berikut:
   ```env
   DB_DATABASE=nama_database_lokal_anda
   DB_USERNAME=root
   DB_PASSWORD=

   # Konfigurasi Token Wa-Bot
   FONNTE_TOKEN=TOKEN_DARI_DASHBOARD_FONNTE_ANDA
   ```

4. **Generate App Key & Konfigurasi Basis Data**
   ```bash
   php artisan key:generate
   php artisan migrate
   ```

5. **Jalankan Aplikasi Web**
   ```bash
   php artisan serve
   ```
   Aplikasi dashboard dapat diakses via `http://localhost:8000`.

---

## 🔗 Panduan Menyambungkan Webhook Fonnte

Fonnte membutuhkan tautan Webhook aktif yang mengarah ke endpoint `http://[URL-ANDA]/api/whatsapp/fonnte`. Karena Anda menjalankan *localhost*, Anda harus menggunakan Ngrok:

1. **Jalankan Ngrok** (di Window / Command prompt baru)
   ```bash
   ngrok http 8000
   ```
2. Anda akan mendapatkan Forwarding URL (contoh: `https://abcd-123.ngrok-free.dev`).
3. Buka **Dashboard Fonnte** -> **Device**.
4. Isi kolom **Webhook** dengan:
   ```text
   https://abcd-123.ngrok-free.dev/api/whatsapp/fonnte
   ```
5. *(Opsional)* Nyalakan perizinan penerimaan Media jika akun Fonnte Anda berada di tingkatan *Premium/Super*.

---

## 🔒 Default Kredensial Login
Untuk mengakses dashboard Web Admin, Anda dapat merujuk pada kredensial default yang tertulis lengkap di file `CREDENTIALS.md` di proyek ini.

> ©️ 2026 PT Reno Abirama Sakti - Dikembangkan untuk kebutuhan operasional monitoring lapangan.
