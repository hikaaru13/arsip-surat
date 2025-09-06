# Arsip Surat

Aplikasi mini untuk mengarsipkan surat (PDF) dengan fitur cari, unduh, pratinjau, hapus (konfirmasi), serta manajemen **Kategori Surat**. Dibuat dengan **Laravel + Bootstrap**.

## 🎯 Tujuan
Memudahkan pengelolaan arsip surat di instansi/organisasi: unggah PDF, beri kategori, cari cepat berdasarkan judul, dan unduh kembali saat dibutuhkan.

## ✨ Fitur
- Arsip surat: tambah/ubah/hapus, pratinjau PDF, unduh.
- Pencarian judul (contains) di halaman utama.
- Konfirmasi hapus (modal).
- Manajemen **Kategori Surat** (tambah, edit, hapus, cari).
- Halaman **About** (foto, nama, NIM, tanggal pembuatan).
- Validasi: unggah **PDF saja**.
- Penyimpanan file di `storage/app/public/surat` (symlink ke `/storage`).

## 🧱 Tech Stack
- Laravel 10/11/12 
- PHP 8.1+
- MySQL/MariaDB
- Bootstrap 5

## 🗂️ Struktur penting
