lu jual gwe beli

## Requirements

-   PHP >= 8.2
-   Composer
-   Node.js & NPM
-   Git

## langkah2

1. **Clone repository**

    ```bash
    git clone https://github.com/doeta/Tubes-PPL.git
    cd Tubes-PPL
    ```

2. **Install PHP dependencies**

    ```bash
    composer install
    ```

3. **Copy environment file**

    ```bash
    cp .env.example .env
    ```

4. **Setup database**

    - Buat database baru (misal: `tubes_ppl`)
    - Edit file `.env` dan sesuaikan konfigurasi database:

    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=tubes_ppl
    DB_USERNAME=akar
    DB_PASSWORD=rajangoding
    ```

5. **Generate application key**

    ```bash
    php artisan key:generate
    ```

6. **Run migrations**

    ```bash
    php artisan migrate
    ```

7. **Seed database (optional)**

    ```bash
    php artisan db:seed
    ```

8. **Install NPM dependencies**

    ```bash
    npm install
    ```

9. **Build assets**

    ```bash
    npm run build
    ```

10. **Create storage link (jika ada upload file)**

    ```bash
    php artisan storage:link
    ```

11. **Run development server**

    ```bash
    php artisan serve
    ```

12. **Access application**
    - Open browser: http://127.0.0.1:8000

Jika ingin menggunakan hot reload untuk CSS/JS:

```bash
# Terminal 1
php artisan serve

# Terminal 2
npm run dev
```


--cara akses SRS 9-14 punya fikri-
Walkthrough - PDF Reports Implementation
I have implemented the 6 PDF reports as requested (SRS-9 to SRS-14).

Changes Implemented
1. Report Controller
Created App\Http\Controllers\ReportController with methods for each report:

sellerAccounts()
: SRS-9
sellersByProvince()
: SRS-10
productsByRating()
: SRS-11
sellerStock()
: SRS-12
sellerStockByRating()
: SRS-13
urgentStock()
: SRS-14
2. PDF Views
Created Blade templates in resources/views/reports/ matching the specific format requested (headers, columns, footers):

seller_accounts.blade.php: Includes "Nama User", "Nama PIC", "Nama Toko", "Status".
sellers_by_province.blade.php: Grouped by province is removed, now a flat list sorted by province.
products_by_rating.blade.php: Includes "Propinsi".
seller_stock.blade.php
seller_stock_by_rating.blade.php
urgent_stock.blade.php
3. Routes
Registered routes in routes/web.php under /admin/reports and /seller/reports.

Verification Results
Format Verification
I have adjusted the PDF layouts to match the provided images exactly:

Added "Tanggal dibuat: [Date] oleh [User]" subtitle.
Updated table headers and columns.
Added specific footer notes (e.g., "***) urutkan berdasarkan...").
Automated Tests
I created a feature test tests/Feature/ReportTest.php to verify that:

Admin can access admin reports.
Seller can access seller reports.
Unauthorized users cannot access reports.
All reports return a 200 OK status and application/pdf content type.
Test Output:

PASS  Tests\Feature\ReportTest
✓ admin can download seller accounts report
✓ admin can download sellers by province report
✓ admin can download products by rating report
✓ seller can download stock report
✓ seller can download stock by rating report
✓ seller can download urgent stock report
✓ unauthorized users cannot access reports
Manual Verification Steps
To manually test the reports:

Login as Admin (admin@marketplace.com / password).
Navigate to:
/admin/reports/seller-accounts
/admin/reports/sellers-by-province
/admin/reports/products-by-rating
Login as Seller (register a new seller or use existing).
Navigate to:
/seller/reports/stock
/seller/reports/stock-by-rating
/seller/reports/urgent-stock
