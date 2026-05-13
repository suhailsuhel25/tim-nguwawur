# tim-nguwawur

## Gambaran Umum Proyek
Simagang adalah sistem manajemen magang komprehensif yang dirancang untuk menyederhanakan proses pemantauan Praktik Kerja Lapangan (PKL) bagi mahasiswa, dosen, dan administrator. Sistem ini menyediakan platform terpadu untuk mengelola periode magang, detail perusahaan, aktivitas harian, sesi bimbingan, dan penilaian akhir.

## Fitur

### 1. Autentikasi Pengguna & Manajemen Peran
- **Tiga Peran Berbeda**: Mahasiswa, Dosen, dan Admin.
- **Login Aman**: Autentikasi berbasis Email/NIP/ID dengan keamanan kata sandi.
- **Pengalihan Berdasarkan Peran**: Secara otomatis mengalihkan pengguna ke dasbor spesifik mereka setelah login.

### 2. Modul Mahasiswa
- **Pendaftaran Magang**: Mendaftar magang dengan informasi pribadi dan akademik yang detail.
- **Manajemen Dokumen**: Unggah dan kelola dokumen magang yang diperlukan (CV, Surat Pengantar, dll.).
- **Pelacakan Aktivitas Harian**: Mencatat aktivitas harian dengan pelacakan waktu dan pembaruan status.
- **Bimbingan**: Menjadwalkan dan melacak sesi bimbingan dengan dosen.
- **Pemantauan Kemajuan**: Melihat kemajuan magang dan menerima pemberitahuan.

### 3. Modul Dosen
- **Manajemen Bimbingan**: Mengawasi dan mengelola sesi bimbingan untuk mahasiswa yang ditugaskan.
- **Pemantauan Aktivitas**: Meninjau aktivitas harian mahasiswa dan laporan kemajuan.
- **Sistem Pemberitahuan**: Menerima pemberitahuan waktu nyata terkait aktivitas dan permintaan mahasiswa.
- **Penilaian**: Memberikan nilai akhir dan asesmen untuk magang.

### 4. Modul Admin
- **Konfigurasi Sistem**: Mengelola periode magang dan pengaturan sistem.
- **Manajemen Pengguna**: Mengawasi semua akun mahasiswa dan dosen.
- **Manajemen Perusahaan**: Menambah dan mengelola perusahaan mitra.
- **Pemantauan**: Dasbor komprehensif untuk memantau semua aktivitas magang di seluruh institusi.

## Tumpukan Teknologi (Tech Stack)
- **Backend**: PHP, Laravel
- **Frontend**: HTML, JavaScript, Tailwind CSS
- **Database**: MySQL

## Memulai

### Prasyarat
- PHP >= 8.0
- MySQL
- Composer
- Node.js & NPM (untuk aset frontend)

### Instalasi
1. Klon repositori:
   ```bash
   git clone <repository-url>
   cd tim-nguwawur
   ```

2. Instal dependensi PHP:
   ```bash
   composer install
   ```

3. Instal dependensi Node.js:
   ```bash
   npm install
   ```

4. Konfigurasi lingkungan:
   - Salin `.env.example` menjadi `.env`:
     ```bash
     cp .env.example .env
     ```
   - Perbarui kredensial database di `.env`:
     ```ini
     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3306
     DB_DATABASE=simagang
     DB_USERNAME=root
     DB_PASSWORD=
     ```

5. Buat kunci aplikasi:
   ```bash
   php artisan key:generate
   ```

6. Jalankan migrasi database:
   ```bash
   php artisan migrate
   ```

7. Jalankan aplikasi:
   ```bash
   php artisan serve
   ```
   Aplikasi akan dapat diakses di `http://localhost:8000`.

## Penggunaan
- **Login**: Akses halaman login di `http://localhost:8000/login`.
- **Dasbor**:
  - Mahasiswa: `http://localhost:8000/mahasiswa/dashboard`
  - Dosen: `http://localhost:8000/dosen/dashboard`
  - Admin: `http://localhost:8000/admin/dashboard`

## Lisensi
Proyek ini adalah perangkat lunak sumber terbuka yang dilisensikan di bawah [lisensi MIT](https://opensource.org/licenses/MIT).
