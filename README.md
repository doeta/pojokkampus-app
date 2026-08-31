# PojokKampus Marketplace

Platform marketplace untuk mahasiswa menjual dan membeli produk second dan new. Dibangun dengan Laravel 12 dan Tailwind CSS.

## Daftar Isi

-   [Fitur Utama](#fitur-utama)
-   [Tech Stack](#tech-stack)
-   [Requirements](#requirements)
-   [Installation](#installation)
-   [Docker Installation](#docker-installation)
-   [Seeding Data](#seeding-data)
-   [Account Testing](#account-testing)
-   [Troubleshooting](#troubleshooting)
-   [Project Structure](#project-structure)
-   [SRS Compliance](#srs-compliance)

## Fitur Utama

### Untuk Penjual (Seller)

-   Registrasi dan verifikasi email
-   Upload produk dengan gambar
-   Dashboard penjual dengan statistik dan charts
-   Kelola produk (CRUD operations)
-   Laporan PDF

### Untuk Pembeli dan Pengunjung

-   Katalog produk publik
-   Pencarian dan filter produk
-   Review dan rating tanpa login
-   Notifikasi email otomatis

### Untuk Admin

-   Verifikasi akun penjual
-   Dashboard admin dengan analytics
-   Generate berbagai laporan PDF
-   Kelola kategori produk

## Tech Stack

-   Backend: Laravel 12.37.0 (PHP 8.2)
-   Frontend: Blade Templates + Tailwind CSS + Alpine.js
-   Database: MySQL
-   Package Manager: Composer + NPM
-   PDF Generator: DomPDF
-   Charts: Chart.js

## Requirements

Pastikan sistem Anda sudah terinstall:

-   PHP >= 8.2 dengan extensions:
    -   OpenSSL
    -   PDO
    -   Mbstring
    -   Tokenizer
    -   XML
    -   Ctype
    -   JSON
    -   BCMath
    -   Fileinfo
    -   GD
-   Composer 2.x
-   Node.js >= 18.x dan NPM
-   MySQL >= 8.0 atau MariaDB >= 10.3
-   Git

## Installation

### 1. Clone Repository

```bash
git clone https://github.com/doeta/Tubes-PPL.git
cd Tubes-PPL
```

### 2. Install Dependencies

```bash
composer install
npm install
```

### 3. Environment Setup

```bash
cp .env.example .env
php artisan key:generate
```

### 4. Database Configuration

Buat database baru di MySQL:

```sql
CREATE DATABASE pojok_kampus CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Edit file `.env` dan sesuaikan konfigurasi database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pojok_kampus
DB_USERNAME=root
DB_PASSWORD=your_password
```

Untuk email notifications, konfigurasi MAIL_MAILER (opsional):

```env
MAIL_MAILER=log
```

### 5. Run Migration and Link Storage

```bash
php artisan migrate
php artisan storage:link
```

### 6. Build Frontend Assets

```bash
npm run build
```

Untuk development dengan hot-reload:

```bash
npm run dev
```

### 7. Start Application

```bash
php artisan serve
```

Akses aplikasi di: http://127.0.0.1:8000

## Docker Installation (1-Click Setup)

Menjalankan project menggunakan Docker tanpa perlu install PHP, Composer, Node.js, atau MySQL di laptop Anda:

### Prerequisites

-   [Docker Desktop](https://www.docker.com/products/docker-desktop/) (Windows / macOS) atau Docker Engine (Linux)

### 🚀 Cara 1: 1-Click Startup (Paling Mudah)

1. **Clone repository:**
   ```bash
   git clone git@github.com:doeta/pojokkampus-app.git
   cd pojokkampus-app
   ```

2. **Jalankan script starter:**
   - **Windows:** Double click file `start.bat` (atau jalankan `start.bat` di command prompt)
   - **macOS / Linux:** Jalankan `./start.sh`

Script akan otomatis:
- Menyiapkan environment (`.env`)
- Membuild container Docker untuk PHP, Nginx, MySQL, phpMyAdmin, dan Mailhog
- Menjalankan migrasi database
- Mengisi data awal (Admin, Seller, Kategori) secara otomatis jika database baru
- Membuka browser ke `http://localhost:8000`

3. **1-Click Stop / Seed Script:**
   - Hentikan container: jalankan `stop.bat` (Windows) atau `./stop.sh` (Mac/Linux)
   - Reseed data produk & dummy: jalankan `seed.bat` (Windows) atau `./seed.sh` (Mac/Linux)

---

### 💻 Cara 2: Menggunakan Terminal / Docker Compose

1. **Clone repository:**
   ```bash
   git clone git@github.com:doeta/pojokkampus-app.git
   cd pojokkampus-app
   cp .env.docker .env
   ```

2. **Build dan jalankan container:**
   ```bash
   docker compose up -d --build
   ```

### 🌐 Akses Layanan

-   **Aplikasi Utama**: [http://localhost:8000](http://localhost:8000)
-   **phpMyAdmin**: [http://localhost:8080](http://localhost:8080)
-   **Mailhog (Email Inbox)**: [http://localhost:8025](http://localhost:8025)

### 🔑 Akun Bawaan (Default Credentials)

-   **Admin**: `admin@admin.com` / `admin123`
-   **Seller**: `seller@test.com` / `seller123`

### 🛠️ Docker Commands Berguna

```bash
# Start containers
docker compose up -d

# Stop containers
docker compose down

# View live logs
docker compose logs -f app

# Akses bash di dalam container app
docker compose exec app bash

# Jalankan perintah artisan
docker compose exec app php artisan <command>

# Reseed database lengkap dengan gambar placeholder
docker compose exec app php artisan db:seed --class=ProductWithImagesSeeder
docker compose exec app php artisan db:seed --class=ReviewSeeder

# Reset total database & data
docker compose exec app php artisan migrate:fresh --seed
```

## Seeding Data

Untuk testing, Anda bisa mengisi database dengan data dummy:

### Option 1: Seed Semua Data

```bash
php artisan db:seed --class=CategorySeeder
php artisan db:seed --class=AdminSeeder
php artisan db:seed --class=TestSellerSeeder
php artisan db:seed --class=ProductWithImagesSeeder
php artisan db:seed --class=ReviewSeeder
```

### Option 2: Reset dan Seed Fresh

```bash
php artisan migrate:fresh --seed
```

Seeder akan membuat:

-   10 kategori produk
-   1 akun admin
-   1 akun seller dengan toko
-   50 produk dengan gambar
-   162 reviews dengan ratings

## Account Testing

Setelah seeding, gunakan akun berikut:

### Admin Account

-   Email: admin@admin.com
-   Password: admin123
-   Akses: Dashboard admin, verifikasi seller, laporan PDF

### Test Seller Account

-   Email: seller@test.com
-   Password: seller123
-   Akses: Dashboard penjual, kelola produk, lihat statistik

### Register Seller Baru

Buat akun seller baru melalui: http://localhost:8000/register-seller

## Troubleshooting

### Error: No application encryption key has been specified

```bash
php artisan key:generate
```

### Error: Storage link sudah ada

```bash
rm public/storage
php artisan storage:link
```

### Error: Migration failed

```bash
php artisan migrate:fresh
```

### Error: Permission denied (Linux/Mac)

```bash
chmod -R 775 storage bootstrap/cache
chown -R $USER:www-data storage bootstrap/cache
```

### Assets tidak muncul / CSS tidak apply

```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
npm run build
```

### PHP PDO MySQL Extension not installed

Windows (enable in php.ini):

```
extension=pdo_mysql
```

Ubuntu/Debian:

```bash
sudo apt-get install php8.2-mysql
```

macOS:

```bash
brew install php@8.2
```

## Project Structure

```
├── app/
│   ├── Http/Controllers/     # Controllers
│   ├── Models/               # Eloquent Models
│   ├── Mail/                 # Email templates
│   └── Notifications/        # Email notifications
├── database/
│   ├── migrations/           # Database migrations
│   └── seeders/              # Database seeders
├── public/
│   ├── images/               # Static images
│   ├── js/                   # Custom JavaScript
│   └── storage/              # Symlink ke storage/app/public
├── resources/
│   ├── views/                # Blade templates
│   └── css/                  # Tailwind CSS
├── routes/
│   └── web.php               # Web routes
└── storage/
    └── app/public/
        ├── product-images/   # Product images
        └── ktp-files/        # KTP verification files
```

Built with ❤️ by PojokKampus
