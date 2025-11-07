# Sistem Informasi Perpustakaan (Kerja Praktik)

![Project Banner](screenshots/cover.png)

Dikerjakan oleh: Deden Khoerul Fahmi & Kusmawan

---

## Ringkasan

Sistem Informasi Perpustakaan ini dibuat untuk membantu digitalisasi operasional perpustakaan kecil/menengah: pengelolaan buku, anggota, peminjaman & pengembalian, pencatatan denda, absensi pengunjung, dan laporan aktivitas. Aplikasi dibangun menggunakan CodeIgniter 4 dengan antarmuka berbasis Bootstrap 5 dan template Modernize.

Versi ini fokus pada alur manual (tanpa otomatisasi QR code). Sistem siap dijalankan di lingkungan lokal (mis. XAMPP) atau server PHP yang kompatibel.

## Sorotan fitur

- Autentikasi pengguna dan dashboard admin
- Manajemen data buku (judul, pengarang, kategori, stok)
- Manajemen anggota dan guru
- Proses peminjaman & pengembalian dengan perhitungan denda
- Absensi pengunjung perpustakaan
- Laporan aktivitas perpustakaan untuk keperluan administrasi
- UI modern dan responsif (Bootstrap 5 + template Modernize)

## Teknologi

- PHP (CodeIgniter 4)
- Bootstrap 5
- MySQL/MariaDB (melalui XAMPP atau server serupa)
- Composer untuk dependency management

## Screenshot

Lihat folder `screenshots/` untuk beberapa contoh tampilan.
Jika ingin menampilkan screenshot di README, letakkan file gambar di `screenshots/` dan ganti path di atas.

## Prasyarat (Windows / XAMPP)

- PHP 7.4+ atau PHP 8.x
- Composer
- XAMPP (Apache + MySQL) atau stack serupa

## Cepat: Cara menjalankan di Windows (XAMPP)

1. Salin/clone proyek ke folder htdocs XAMPP, contoh:

```powershell
# contoh: jalankan di PowerShell
cd C:\xampp\htdocs
git clone <repo-url> sistem-perpustakaan-qr-code
cd sistem-perpustakaan-qr-code
```

2. Install dependensi PHP dengan Composer (di direktori proyek):

```powershell
composer install
```

3. Siapkan database:

- Buat database baru melalui phpMyAdmin (mis. nama: perpustakaan).
- Jika ada file SQL di folder `database/` atau `builds/`, import file tersebut ke database.

4. Konfigurasi environment:

- Salin `app/Config/Database.php` atau sesuaikan `app/Config/App.php` sesuai kebutuhan (set baseURL).
- Pastikan folder `writable/` dan `writable/uploads/` dapat ditulis oleh webserver.

5. Jalankan XAMPP (Apache + MySQL) dan buka aplikasi di browser:

```
http://localhost/sistem-perpustakaan-qr-code/public
```

Catatan: Jika menempatkan proyek langsung di root htdocs, sesuaikan URL sesuai folder.

## Struktur singkat proyek

- `app/` - kode aplikasi (Controllers, Models, Config)
- `public/` - entry point web, assets (css/js/images)
- `writable/` - cache, logs, uploads (pastikan writable)
- `database/` - skema / seed (jika ada)

## Kontribusi

Kontribusi kecil sangat diterima: perbaikan UI, fitur tambahan, dokumentasi, atau perbaikan bug.

Langkah umum:

1. Fork repo
2. Buat branch fitur: `git checkout -b fitur-nama`
3. Commit perubahan, push, dan ajukan pull request

## Lisensi

Proyek ini dilisensikan di bawah MIT License — lihat file `LICENSE` untuk detail.

## Penulis & Kontak

- Deden Khoerul Fahmi
- Kusmawan

Untuk pertanyaan atau bantuan, buka issue di repository atau hubungi pembuat proyek.

---

Terima kasih telah melihat proyek ini! Jika Anda ingin saya menambahkan badge build/coverage atau contoh data (seed) ke README, beri tahu saya dan saya akan tambahkan.
