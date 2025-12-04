# 🚀 Quick Setup Guide - PojokKampus

Panduan cepat untuk setup project ini di komputer lokal.

## ⚡ Quick Start (5 Menit)

```bash
# 1. Clone repository
git clone https://github.com/doeta/Tubes-PPL.git
cd Tubes-PPL

# 2. Install dependencies
composer install && npm install

# 3. Setup environment
cp .env.example .env
php artisan key:generate

# 4. Configure database di .env
# Edit DB_DATABASE, DB_USERNAME, DB_PASSWORD

# 5. Setup database
php artisan migrate
php artisan storage:link

# 6. Seed data testing (opsional tapi recommended)
php artisan db:seed --class=CategorySeeder
php artisan db:seed --class=AdminSeeder
php artisan db:seed --class=TestSellerSeeder
php artisan db:seed --class=ProductWithImagesSeeder
php artisan db:seed --class=ReviewSeeder

# 7. Build assets & run
npm run build
php artisan serve
```

Buka: **http://localhost:8000**

## 🔑 Default Accounts

Setelah seeding, gunakan:

**Admin:**

-   Email: `admin@admin.com`
-   Password: `admin123`

**Seller:**

-   Email: `seller@test.com`
-   Password: `seller123`

## 📝 Checklist Setup

-   [ ] PHP 8.2+ installed
-   [ ] Composer installed
-   [ ] Node.js & NPM installed
-   [ ] MySQL running
-   [ ] Database created
-   [ ] `.env` configured
-   [ ] Migrations run
-   [ ] Storage linked
-   [ ] Seeders run (optional)
-   [ ] Assets built
-   [ ] Server running

## ❌ Common Issues

### "Class 'PDO' not found"

Install PHP MySQL extension:

```bash
# Windows: Enable di php.ini
extension=pdo_mysql

# Ubuntu/Debian
sudo apt-get install php8.2-mysql

# Mac (Homebrew)
brew install php@8.2
```

### "npm run build" error

```bash
# Clear cache
npm cache clean --force
rm -rf node_modules package-lock.json
npm install
```

### Database connection failed

Pastikan:

1. MySQL service running
2. Database sudah dibuat
3. `.env` DB credentials benar

### Permission error (Linux/Mac)

```bash
chmod -R 775 storage bootstrap/cache
```

## 📦 Minimal .env Configuration

```env
APP_NAME="PojokKampus"
APP_URL=http://localhost:8000
APP_ENV=local
APP_DEBUG=true

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pojok_kampus
DB_USERNAME=root
DB_PASSWORD=

# Email (gunakan Mailtrap untuk testing)
MAIL_MAILER=log
MAIL_FROM_ADDRESS=noreply@pojokampus.com
```

## 🎯 Next Steps

1. ✅ Setup selesai? Test login dengan akun admin/seller
2. 📦 Explore fitur: Dashboard, Katalog, Review
3. 🧪 Test upload produk sebagai seller
4. 📊 Lihat dashboard analytics
5. 📄 Generate laporan PDF

## 💬 Need Help?

-   Baca [README.md](README.md) lengkap
-   Check [MARKETPLACE_README.md](MARKETPLACE_README.md) untuk dokumentasi fitur
-   Buat issue di GitHub jika ada bug

---


