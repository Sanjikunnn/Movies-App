# 🎬 Aplikasi Movie Laravel 5.8

[](https://laravel.com/)
[](https://www.php.net/)
[](https://supabase.com/)
[](http://www.omdbapi.com/)

Aplikasi ini adalah platform dinamis untuk menjelajahi, mencari, dan mengelola daftar film favorit Anda. Dibangun menggunakan **Laravel 5.8**, aplikasi ini terintegrasi dengan **OMDb API** dan mendukung multi-bahasa, serta fitur-fitur modern seperti *infinite scroll* dan *lazy load* untuk pengalaman pengguna yang optimal, serta implementasi desain frontend dengan tema neobrutalism dengan collor pallete yang sangat berani.

-----

## 🌟 Fitur Utama

Aplikasi ini dirancang dengan serangkaian fitur untuk memberikan pengalaman yang lengkap:

  * **Sistem Otentikasi Pengguna**:
      * Halaman **Login** yang aman dengan kredensial tetap.
      * Proteksi rute untuk halaman `List Movie` dan `Detail Movie`.
      * Pesan kesalahan yang informatif untuk kredensial tidak valid.
  * **Daftar Film (List Movie)**:
      * Menampilkan film dari **OMDb API** secara *real-time*.
      * Fungsi **pencarian film** yang fleksibel dengan berbagai parameter.
      * **Infinite Scroll** untuk memuat data selanjutnya secara otomatis.
      * **Lazy Load** gambar/poster film untuk performa optimal.
      * Tombol untuk **menambahkan/menghapus film ke favorit** langsung dari daftar.
  * **Detail Film (Detail Movie)**:
      * Menampilkan informasi detail lengkap dari film yang dipilih.
      * Tombol untuk **menambahkan/menghapus film dari favorit** juga tersedia di sini.
  * **Film Favorit (Favorite Movies)**:
      * Halaman khusus untuk melihat dan mengelola daftar film favorit Anda.
      * Fungsi untuk **menghapus film dari daftar favorit** yang mudah digunakan.
  * **Dukungan Multi-Bahasa (ID / EN)**:
      * Mendukung Bahasa Indonesia (ID) dan Inggris (EN) sebagai bahasa default.
      * Pengguna dapat mengganti bahasa di UI dengan mudah.
      * Lokalisasi diterapkan pada teks statis aplikasi.
  * **Desain Responsif**: UI/UX yang bersih, modern, dan **adaptif** untuk berbagai perangkat.
  * **Kerapian Kode**: Struktur kode yang terorganisir, mudah dibaca, dan mengikuti praktik terbaik Laravel.
  * **Keamanan Aplikasi**: Implementasi otentikasi dasar untuk melindungi akses.
  * **Filter & Pencarian**: Parameter pencarian yang fleksibel untuk memudahkan penemuan film.
  * **Empty Layout**: Tampilan informatif saat data tidak ditemukan.

-----

## 🔑 Kredensial Login

Gunakan kredensial berikut untuk masuk ke aplikasi:

  * **Username**: `aldmic`
  * **Password**: `123abc123`

-----

## 🛠️ Teknologi yang Digunakan

Proyek ini dibangun menggunakan kombinasi teknologi berikut:

  * **Framework**: [Laravel 5.8](https://laravel.com/)
  * **Bahasa Pemrograman**: [PHP 7.4](https://www.php.net/)
  * **Manajemen Dependensi PHP**: [Composer](https://getcomposer.org/)
  * **Manajemen Dependensi Frontend**: [NPM](https://www.npmjs.com/)
  * **Styling**: [Bootstrap](https://bootstrap.com/)
  * **API Eksternal**: [OMDb API](http://www.omdbapi.com/)
  * **Database**: [Supabase PostgreSQL](https://supabase.com/) (terhubung via Session Pooler)

-----

## 🚀 Persyaratan Sistem

Pastikan lingkungan development lokal Anda memenuhi persyaratan berikut:

  * **PHP 7.4**
  * **Composer**
  * **Ekstensi PHP Esensial**: Pastikan ekstensi seperti `pdo_pgsql`, `mbstring`, `openssl`, `json`, `curl`, `gd`, `fileinfo`, dll., sudah terinstal dan aktif.

-----

## ⚙️ Setup Proyek (Lokal)

Ikuti langkah-langkah detail ini untuk menjalankan proyek di lingkungan lokal Anda tanpa Docker:

1.  ### **Clone Repositori**

    Ambil kode proyek dari GitHub:

    ```bash
    git clone https://github.com/Sanjikunnn/movies-app
    cd movies-app
    ```

2.  ### **Instal Dependensi PHP**

    Pasang semua *library* PHP yang dibutuhkan oleh Laravel:

    ```bash
    composer install
    ```

3.  ### **Instal Dependensi JavaScript**

    Pasang semua *library* JavaScript dan *tools frontend* (seperti Tailwind CSS):

    ```bash
    npm install
    ```

4.  ### **Konfigurasi Environment (`.env`)**

    Salin contoh file `.env.example` ke `.env`:

    ```bash
    cp .env.example .env
    ```

    Buka file `.env` dan atur variabel-variabel berikut untuk koneksi ke **Supabase PostgreSQL** (via Session Pooler) dan **OMDb API Key** Anda:

    ```dotenv
    APP_NAME=MovieApp
    APP_ENV=local
    APP_KEY= # Akan di-generate di langkah selanjutnya. JANGAN DIISI MANUAL!
    APP_DEBUG=true
    APP_URL=http://localhost

    # Konfigurasi Database Supabase PostgreSQL (dengan Session Pooler)
    DB_CONNECTION=pgsql
    DB_HOST=YOUR_SUPABASE_HOST.supabase.co # Ganti dengan host Supabase Anda (misal: db.xyz.supabase.co)
    DB_PORT=6543 # Port standar untuk Session Pooler di Supabase
    DB_DATABASE=postgres # Nama database default di Supabase Anda
    DB_USERNAME=postgres.YOUR_USER_ID # Ganti dengan username database Anda (cek di dashboard Supabase)
    DB_PASSWORD=YOUR_SUPABASE_PASSWORD # Ganti dengan password database Anda

    # Penting: Aktifkan SSL untuk koneksi aman ke Supabase PostgreSQL
    PGSSLMODE=require

    # OMDb API Key
    OMDB_API_KEY=YOUR_OMDB_API_KEY_HERE # Dapatkan API Key Anda dari http://www.omdbapi.com/apikey.aspx
    ```

      * **`DB_HOST`**: Gunakan alamat *session pooler* dari dashboard Supabase Anda (contoh: `aws-0-ap-southeast-1.pooler.supabase.com`).
      * **`DB_USERNAME`**: Formatnya biasanya `postgres.YOUR_USER_ID`.

5.  ### **Generate App Key**

    Laravel membutuhkan *application key* untuk enkripsi sesi dan data sensitif lainnya:

    ```bash
    php artisan key:generate
    ```

6.  ### **Migrasi Database**

    Jalankan migrasi database untuk membuat tabel `favorites, dan users` di Supabase PostgreSQL Anda:

    ```bash
    php artisan migrate
    ```

7.  ### **Kompilasi Aset Frontend**

    *Frontend assets* (seperti CSS dari Tailwind) perlu dikompilasi:

    ```bash
    npm run dev  # Untuk pengembangan aktif (memantau perubahan file dan merefresh secara otomatis)
    # ATAU
    npm run prod # Untuk build produksi (file CSS/JS akan di-minify dan dioptimalkan)
    ```

8.  ### **Jalankan Server Lokal**

    Terakhir, jalankan server pengembangan bawaan Laravel:

    ```bash
    php artisan serve
    ```

    Aplikasi Anda sekarang dapat diakses di `http://localhost:8000`.

-----

## 💡 Command Laravel Penting

Berikut adalah beberapa *command* `php artisan` yang akan sangat membantu Anda selama pengembangan:

  * **Menjalankan Server Development:**
    ```bash
    php artisan serve
    ```
  * **Membuat Controller Baru:**
    ```bash
    php artisan make:controller NamaController
    ```
  * **Membuat Model Baru:**
    ```bash
    php artisan make:model NamaModel
    ```
  * **Membuat Migrasi Baru:**
    ```bash
    php artisan make:migration create_nama_tabel_table
    ```
  * **Menjalankan Migrasi Database:**
    ```bash
    php artisan migrate
    ```
  * **Mengembalikan (Rollback) Migrasi Terakhir:**
    ```bash
    php artisan migrate:rollback
    ```
  * **Refresh Migrasi (Rollback semua dan jalankan lagi):**
    ```bash
    php artisan migrate:refresh
    ```
  * **Membersihkan Cache Aplikasi:**
    ```bash
    php artisan cache:clear
    ```
  * **Membersihkan Cache Route:**
    ```bash
    php artisan route:cache
    ```
  * **Membersihkan Cache Config:**
    ```bash
    php artisan config:cache
    ```
  * **Membersihkan Cache View:**
    ```bash
    php artisan view:clear
    ```
  * **Menampilkan Daftar Semua Route:**
    ```bash
    php artisan route:list
    ```
  * **Menjalankan Tinker (REPL untuk Laravel):**
    ```bash
    php artisan tinker
    ```
  * **Mengoptimalkan Autoloading Composer:**
    ```bash
    composer dump-autoload
    ```
  * **Untuk command lainnya, gunakan:**
    ```bash
    php artisan list
    ```

-----

## ⚠️ Pastikan Lingkungan Lokal Anda

Karena Anda tidak menggunakan Docker, Anda bertanggung jawab penuh atas instalasi dan konfigurasi *software* di sistem operasi Anda:

  * **Instalasi PHP 7.4**: Pastikan PHP 7.4 terinstal dengan benar.
  * **Ekstensi PHP yang Aktif**: Verifikasi ekstensi **`pdo_pgsql`** dan ekstensi Laravel lainnya (seperti `mbstring`, `openssl`, `json`, `curl`, `gd`, `fileinfo`) sudah aktif di file `php.ini` Anda. Anda mungkin perlu menginstal paket tambahan (misal: `sudo apt install php7.4-pgsql` di Ubuntu) dan me-restart *web server* atau PHP-FPM.
  * **PostgreSQL Client**: Memiliki `psql` (command-line client PostgreSQL) secara lokal dapat sangat membantu untuk *debugging* koneksi atau interaksi langsung dengan database Supabase.
