🎬 Aplikasi Movie Laravel 5: Temukan, Favoritkan, dan Nikmati Film!
Selamat datang di proyek Aplikasi Movie berbasis Laravel 5! Ini adalah platform dinamis yang memungkinkan pengguna untuk menjelajahi daftar film, mencari berdasarkan berbagai kriteria, melihat detail lengkapnya, serta menyimpan film favorit mereka. Dibangun dengan fokus pada pengalaman pengguna yang intuitif dan performa yang optimal, aplikasi ini siap menjadi demo portofolio yang mengagumkan.
✨ Fitur Unggulan
Sistem Otentikasi Pengguna yang Kuat:
Halaman Login yang aman dengan kredensial yang ditentukan.
Rute-rute penting seperti Daftar Film dan Detail Film dilindungi, memastikan hanya pengguna yang terotentikasi yang bisa mengaksesnya.
Pesan Kesalahan yang jelas dan informatif jika kredensial yang dimasukkan tidak valid.
Jelajah Film Tanpa Batas (List Movie):
Integrasi mulus dengan OMDb API untuk menghadirkan koleksi film yang luas.
Fungsi Pencarian Film yang fleksibel dengan berbagai parameter (judul, tahun, tipe).
Infinite Scroll yang canggih untuk memuat film secara otomatis saat scroll ke bawah, memberikan pengalaman Browse yang lancar.
Lazy Load gambar/poster film, memastikan halaman dimuat dengan cepat dan efisien.
Tombol intuitif untuk Menambahkan/Menghapus Film ke Favorit langsung dari daftar.
Detail Film Mendalam (Detail Movie):
Tampilkan Informasi Detail lengkap untuk setiap film, termasuk plot, rating, sutradara, aktor, dan lainnya.
Kemampuan untuk Menambahkan/Menghapus Film ke Favorit dari halaman detail, memberikan kenyamanan ekstra.
Koleksi Film Favorit Pribadi (Favorite Movies):
Halaman khusus untuk melihat semua film yang telah ditandai sebagai favorit oleh pengguna.
Fungsi Hapus Favorit yang mudah digunakan untuk mengelola koleksi pribadi.
Dukungan Multi-Bahasa (ID / EN):
Aplikasi mendukung dua bahasa: Indonesia (ID) dan Inggris (EN).
Bahasa default yang digunakan adalah Inggris (EN), namun pengguna dapat dengan mudah menggantinya.
Lokalisasi diterapkan pada teks statis di antarmuka pengguna, menjaga konsistensi data dari OMDb API.
Desain UI/UX yang Responsif:
Antarmuka yang bersih, modern, dan responsif, memastikan tampilan yang optimal di berbagai perangkat.
Kerapian dan Kualitas Kode:
Struktur kode yang terorganisir, penamaan variabel dan fungsi yang konsisten, serta indentasi yang rapi.
Implementasi keamanan aplikasi dasar melalui sistem otentikasi.
Penanganan empty layout yang elegan jika tidak ada data yang ditemukan, memberikan umpan balik yang baik kepada pengguna.
🔑 Kredensial Login
Gunakan kredensial berikut untuk masuk ke aplikasi:
Username: aldmic
Password: 123abc123
🛠️ Teknologi yang Digunakan
Framework: Laravel 5.x (dengan filosofi MVC yang kuat)
Bahasa Pemrograman: PHP 7.4 (memastikan kompatibilitas dan performa)
Manajemen Dependensi PHP: Composer
Manajemen Dependensi Frontend: NPM
Styling: Tailwind CSS (untuk styling yang cepat dan fleksibel)
API Eksternal: OMDb API (sumber data film utama)
Database: Supabase PostgreSQL (terhubung dengan efisien melalui Session Pooler)
🚀 Persyaratan Sistem
Pastikan lingkungan development lokal Anda memenuhi persyaratan berikut:
PHP 7.4
Composer
Node.js & NPM
Ekstensi PHP yang Esensial: pdo_pgsql, mbstring, openssl, json, curl, gd, fileinfo, dll. (penting untuk fungsionalitas penuh Laravel dan koneksi PostgreSQL).
⚙️ Setup Proyek (Lokal - Tanpa Docker)
Ikuti langkah-langkah detail ini untuk menjalankan proyek di lingkungan lokal Anda tanpa Docker:
Clone Repositori:
Buka terminal atau command prompt Anda, lalu clone repositori proyek ini:
git clone <URL_REPOSitori_ANDA>
cd <nama_folder_proyek> # Masuk ke direktori proyek


Instal Dependensi PHP:
Gunakan Composer untuk menginstal semua library PHP yang dibutuhkan oleh Laravel:
composer install


Instal Dependensi JavaScript:
Gunakan NPM untuk menginstal semua library JavaScript dan tools frontend (seperti Tailwind CSS):
npm install


Konfigurasi Environment (.env):
Aplikasi ini menggunakan file .env untuk konfigurasi lingkungan. Salin contoh file .env`:
cp .env.example .env

Kemudian, buka file .env yang baru dan sesuaikan variabel-variabel berikut untuk koneksi ke Supabase PostgreSQL melalui Session Pooler, serta OMDb API Key Anda:
APP_NAME=LaravelMovieApp
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


Catatan DB_HOST: Pastikan ini adalah alamat session pooler Supabase Anda, bukan alamat database langsung. Port 6543 adalah port default untuk session pooler.
Catatan DB_USERNAME: Formatnya biasanya postgres.YOUR_USER_ID. Anda bisa menemukannya di pengaturan database Supabase Anda.
Generate App Key:
Laravel membutuhkan application key untuk enkripsi sesi dan data sensitif lainnya. Jalankan command ini untuk meng-generate-nya:
php artisan key:generate


Migrasi Database (untuk Fitur Favorit):
Aplikasi ini memiliki tabel favorites untuk menyimpan film favorit pengguna. Jalankan migrasi database untuk membuat tabel ini di Supabase PostgreSQL Anda:
php artisan migrate

Laravel akan secara otomatis menggunakan koneksi database yang telah Anda konfigurasikan di file .env.
Kompilasi Aset Frontend:
Frontend assets (seperti CSS dari Tailwind) perlu dikompilasi. Jalankan command berikut:
npm run dev  # Untuk pengembangan aktif (memantau perubahan file dan merefresh secara otomatis)
# ATAU
npm run prod # Untuk build produksi (file CSS/JS akan di-minify dan dioptimalkan)


Jalankan Server Lokal:
Terakhir, jalankan server pengembangan bawaan Laravel:
php artisan serve

Aplikasi Anda sekarang harus bisa diakses di http://localhost:8000. Selamat menjelajah film!
💻 Command Laravel Penting Lainnya
Sebagai seorang developer Laravel, command php artisan akan menjadi sahabat terbaik Anda. Berikut adalah beberapa yang paling sering digunakan:
Menjalankan Server Development:
php artisan serve


Membuat Controller Baru:
php artisan make:controller NamaController
# Contoh: php artisan make:controller MovieController


Membuat Model Baru:
php artisan make:model NamaModel
# Contoh: php artisan make:model Favorite


Membuat Migrasi Baru:
php artisan make:migration create_nama_tabel_table
# Contoh: php artisan make:migration create_favorites_table


Menjalankan Migrasi Database:
php artisan migrate


Mengembalikan (Rollback) Migrasi Terakhir:
php artisan migrate:rollback


Refresh Migrasi (Rollback semua dan jalankan lagi):
php artisan migrate:refresh


Membuat Seeder Baru (untuk data dummy):
php artisan make:seeder NamaSeeder
# Contoh: php artisan make:seeder UsersTableSeeder


Menjalankan Seeder:
php artisan db:seed # Akan menjalankan DatabaseSeeder
php artisan db:seed --class=NamaSeeder # Menjalankan seeder spesifik


Membuat Factory Baru (untuk membuat model dummy):
php artisan make:factory NamaFactory
# Contoh: php artisan make:factory PostFactory


Membersihkan Cache Aplikasi (penting setelah perubahan config/code):
php artisan cache:clear


Membersihkan Cache Route:
php artisan route:cache # Mengoptimalkan loading route


Membersihkan Cache Config:
php artisan config:cache # Mengoptimalkan loading konfigurasi


Membersihkan Cache View:
php artisan view:clear


Membuat Request Baru (untuk validasi form yang lebih rapi):
php artisan make:request NamaRequest
# Contoh: php artisan make:request StoreMovieRequest


Membuat Middleware Baru:
php artisan make:middleware NamaMiddleware
# Contoh: php artisan make:middleware EnsureUserIsLoggedIn


Menampilkan Daftar Semua Route yang Terdaftar:
php artisan route:list


Menjalankan Test Aplikasi:
php artisan test


Menjalankan Tinker (Lingkungan REPL untuk Laravel):
php artisan tinker # Untuk berinteraksi dengan aplikasi via command line


Mengoptimalkan Autoloading Composer:
composer dump-autoload # Berguna setelah menambahkan kelas baru secara manual


Membuat Job Baru (untuk background processing dengan Queue):
php artisan make:job NamaJob


Menjalankan Queue Worker (untuk memproses job):
php artisan queue:work


Membuat Event Baru:
php artisan make:event NamaEvent


Membuat Listener Baru:
php artisan make:listener NamaListener --event=NamaEvent


Membuat Resource Controller (untuk CRUD standar):
php artisan make:controller NamaController --resource


Membuat API Resource Controller (tanpa create/edit methods):
php artisan make:controller NamaController --api


Membuat Resource Baru (untuk transformasi data API):
php artisan make:resource NamaResource


Membuat Kebijakan Baru (untuk Authorization):
php artisan make:policy NamaPolicy


Membuat Komponen Blade Baru:
php artisan make:component NamaKomponen


⚠️ Yang Perlu Kamu Pastikan di Lingkungan Lokalmu
Karena kamu memilih setup tanpa Docker, kamu bertanggung jawab penuh atas instalasi dan konfigurasi software di sistem operasi kamu:
Instalasi PHP 7.4: Pastikan kamu sudah menginstal PHP versi 7.4. Cara instalasinya bervariasi tergantung sistem operasi yang kamu gunakan (misalnya, via Homebrew di macOS, APT di Ubuntu, atau menggunakan paket seperti XAMPP/WAMP di Windows).
Ekstensi PHP yang Aktif: Setelah instalasi PHP, sangat penting untuk memastikan ekstensi pdo_pgsql dan ekstensi Laravel lainnya (seperti mbstring, openssl, json, curl, gd, fileinfo) sudah aktif di file php.ini kamu. Kamu mungkin perlu menginstal paket ekstensi tambahan secara manual (contoh: sudo apt install php7.4-pgsql di Ubuntu) dan me-restart web server atau PHP-FPM jika kamu menggunakannya.
PostgreSQL Client: Meskipun database utama berada di Supabase, memiliki command-line client PostgreSQL (psql) yang terinstal secara lokal dapat sangat membantu untuk debugging koneksi atau berinterinteraksi langsung dengan database jika diperlukan.
Dengan panduan README.md yang super lengkap ini, kamu sekarang punya semua yang dibutuhkan untuk kick-start dan mengelola proyek Aplikasi Movie Laravel 5 kamu dengan mudah. Selamat coding, bray!
Ada lagi yang ingin kamu tambahkan atau perbaiki?
