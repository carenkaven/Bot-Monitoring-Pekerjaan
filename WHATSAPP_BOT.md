# WhatsApp Bot Laporan

Bot ini memakai WhatsApp Web melalui Baileys. Jalankan dari laptop, scan QR, lalu pesan karyawan yang diawali `LAPOR` akan diteruskan ke Laravel dan masuk ke menu laporan website.

## Menjalankan

Pastikan Laravel aktif:

```powershell
php artisan serve --host=127.0.0.1 --port=8000
```

Pastikan storage link ada:

```powershell
php artisan storage:link
```

Jalankan bot:

```powershell
npm run wa:bot
```

Scan QR yang muncul memakai WhatsApp > Linked devices.

## Format Pesan

```text
LAPOR
Nama Proyek: Pembangunan Jalan Lingkar Barat
Kegiatan: Pekerjaan Beton
Sub Kegiatan: Rigid Pavement
Pekerjaan: Pengecoran
Lokasi: Jl. Raya Tlogomas
Tanggal: 2026-07-16
Minggu Ke: 1
Tenaga: pekerja=8, tukang=4, mandor=1, pelaksana=1
Material: Semen Portland|20|sak; Pasir Beton|3|m3
Alat: Concrete Mixer|1; Vibrator|2
Catatan: Cuaca cerah
```

Nomor WhatsApp pengirim harus sama dengan `no_hp` karyawan, dan karyawan harus aktif serta sudah diverifikasi.
