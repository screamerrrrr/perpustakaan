📚 PERPUSTAKAAN (LARAVEL + POSTGRESQL)
ini adalah aplikasi manajemen perpustakaan, dibuat pakai **Laravel** dengan *database* **PostgreSQL**
## 🚀 Cara Install Singkat
# 1. Clone & Masuk Folder
git clone [https://github.com/screamerrrrr/perpustakaan.git](https://github.com/screamerrrrr/perpustakaan.git)
cd perpustakaan
# 2. Setup File dan Dependencies
cp .env.example .env
composer install
npm install
# 3. Compile Assets (Wajib buat CSS/JS)
npm run dev 
# 4. Kunci Aplikasi & Database
php artisan key:generate
# PASTIKAN koneksi PGSQL di .env sudah benar SEBELUM migrate
php artisan migrate --seed
⚠️ PENTING: Cek dan edit file .env Anda, terutama bagian DB_CONNECTION=pgsql dan DB_DATABASE, DB_USERNAME, DB_PASSWORD.

🔒 Roles dan Fitur Utama
Aplikasi ini punya 2 jenis pengguna:

👑 Admin (Manajemen Penuh)
Admin bisa mengurus semua data:
Manajemen Buku: CRUD (Buat, Lihat, Edit, Hapus) dan update stok buku.
Manajemen User: Mengelola data dan role semua pengguna.
Pencatatan Peminjaman: Mencatat peminjaman. Peminjam dicari berdasarkan Nama/Username yang sudah terdaftar.
👤 User (Anggota)
Anggota hanya bisa melihat info yang relevan:
Katalog Buku: Melihat daftar dan stok buku.


💡 Troubleshooting Cepat
Database Error: Cek koneksi di .env dan pastikan server PostgreSQL Anda ON.
Akses Ditolak (403): Pastikan Anda login sebagai Admin untuk mengakses fitur manajemen.
