# Monitoring Pekerjaan dan Laporan

Sistem monitoring pekerjaan lapangan berbasis Laravel yang menghubungkan dashboard operasional dengan bot WhatsApp. Karyawan dapat mengirim laporan harian dari WhatsApp, sementara administrator dapat memantau, memverifikasi, dan mengekspor data laporan melalui dashboard.

## Fitur utama

- Manajemen data karyawan dan status akses.
- Pencatatan laporan harian, tenaga kerja, material, alat, progres, dan dokumentasi foto.
- Alur verifikasi laporan: menunggu, disetujui, atau ditolak dengan catatan.
- Rekap laporan harian dan mingguan serta ekspor PDF dan Excel.
- Bot WhatsApp berbasis Fonnte untuk menerima laporan, menampilkan menu, dan memberikan respons otomatis.
- Pembatasan balasan bot untuk mencegah pesan berulang dan pengiriman berlebihan.

## Arsitektur singkat

```text
Karyawan → WhatsApp → Fonnte → Webhook Laravel → MySQL
                                           ↓
                                  Dashboard Administrator
```

## Teknologi

- PHP 8.3 dan Laravel 13
- MySQL atau MariaDB
- Vite dan Tailwind CSS
- Fonnte WhatsApp API
- DomPDF dan PhpSpreadsheet untuk ekspor laporan

## Prasyarat

Sebelum memulai, pastikan perangkat sudah memiliki:

- PHP 8.3 atau lebih baru beserta ekstensi yang dibutuhkan Laravel
- Composer 2
- Node.js 20 atau lebih baru dan npm
- MySQL/MariaDB
- Akun Fonnte dengan device WhatsApp yang terhubung
- Ngrok untuk menerima webhook saat pengembangan lokal

## Instalasi lokal

1. Kloning repositori dan masuk ke direktori proyek.

   ```bash
   git clone https://github.com/carenkaven/Bot-Monitoring-Pekerjaan.git
   cd Bot-Monitoring-Pekerjaan
   ```

2. Siapkan konfigurasi lingkungan.

   ```bash
   copy .env.example .env
   ```

   Di PowerShell, gunakan `Copy-Item .env.example .env`.

3. Pasang dependensi PHP dan JavaScript.

   ```bash
   composer install
   npm ci
   ```

4. Sesuaikan `.env`, terutama konfigurasi berikut.

   ```env
   APP_URL=http://localhost:8000

   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=nama_database
   DB_USERNAME=root
   DB_PASSWORD=

   FONNTE_TOKEN=token_dari_dashboard_fonnte
   ```

5. Buat kunci aplikasi, tabel database, dan tautan penyimpanan publik.

   ```bash
   php artisan key:generate
   php artisan migrate --seed
   php artisan storage:link
   ```

6. Buat aset frontend untuk lingkungan produksi, bila diperlukan.

   ```bash
   npm run build
   ```

> Jangan menyimpan token Fonnte, kata sandi, atau isi `.env` di repositori.

## Menjalankan aplikasi

Untuk pengembangan lokal, jalankan:

```bash
php artisan start
```

Perintah tersebut menjalankan layanan berikut secara bersamaan:

| Layanan | Alamat atau fungsi |
| --- | --- |
| Laravel | Dashboard di `http://127.0.0.1:8000` |
| Vite | Kompilasi dan hot reload aset frontend |
| Queue worker | Memproses antrean balasan WhatsApp |
| Ngrok | Membuka endpoint lokal untuk webhook Fonnte |

Gunakan `Ctrl+C` untuk menghentikan seluruh layanan.

## Menghubungkan webhook Fonnte

1. Jalankan `php artisan start`.
2. Salin URL HTTPS Ngrok yang tampil pada terminal, misalnya `https://contoh.ngrok-free.dev`.
3. Buka dashboard Fonnte, pilih device WhatsApp yang digunakan, lalu isi Webhook dengan:

   ```text
   https://contoh.ngrok-free.dev/api/whatsapp/fonnte
   ```

4. Simpan pengaturan dan pastikan status device Fonnte adalah **Connected**.
5. Kirim `HAI` atau `1` ke nomor bot untuk pengujian.

URL Ngrok gratis dapat berubah setelah tunnel dijalankan ulang. Jika bot hanya membaca pesan tanpa membalas, periksa kembali URL webhook dan status device Fonnte.

## Penggunaan bot WhatsApp

Bot merespons pesan dari percakapan pribadi dan menyediakan menu berikut:

| Balasan | Fungsi |
| --- | --- |
| `1` atau `LAPOR` | Memulai laporan harian |
| `2` atau `STATUS` | Menampilkan riwayat laporan terakhir |
| `3` atau `BANTUAN` | Menampilkan panduan penggunaan |
| `0` atau `BATAL` | Mengakhiri alur laporan |

Untuk mengirim laporan, balas `LAPOR`, salin formulir yang dikirim bot, lengkapi informasi pekerjaan dan lokasi, lalu kirim dalam satu pesan. Bot akan meminta foto dokumentasi setelah laporan berhasil dicatat.

## Pengaturan pengamanan balasan

Nilai berikut dapat disesuaikan pada `.env` untuk mengurangi balasan duplikat dan membatasi pesan otomatis per pengguna:

```env
FONNTE_MIN_REPLY_INTERVAL_SECONDS=10
FONNTE_RECIPIENT_COOLDOWN_SECONDS=15
FONNTE_DAILY_REPLY_LIMIT=60
FONNTE_INBOUND_DEDUP_SECONDS=20
```

Gunakan bot hanya untuk pengguna yang telah setuju menerima komunikasi operasional. Hindari pengiriman massal atau pesan yang tidak diminta.

## Pemeriksaan dan pengujian

```bash
php artisan test
npm run build
```

Log aplikasi tersedia di `storage/logs/laravel.log`. Untuk memastikan webhook masuk, periksa juga riwayat request pada dashboard atau inspector Ngrok.

## Catatan operasional

- Ganti kredensial akun hasil seeder sebelum digunakan di lingkungan selain lokal.
- Pastikan worker antrean tetap berjalan agar balasan bot terkirim.
- Gunakan domain tunnel tetap atau deployment HTTPS untuk operasi jangka panjang agar URL webhook tidak berubah.

---

© 2026 PT Reno Abirama Sakti. Dibuat untuk kebutuhan monitoring pekerjaan lapangan.
