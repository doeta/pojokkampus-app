# SRS-MartPlace-06: Pemberian Komentar dan Rating

## Deskripsi

Fitur untuk memberikan komentar dan rating pada produk. Pengunjung dapat memberikan review tanpa harus login terlebih dahulu.

## Implementasi

### 1. Database Structure

**Tabel: `reviews`**

-   `id` - Primary key
-   `product_id` - Foreign key ke tabel products
-   `name` - Nama lengkap pengunjung (required)
-   `phone` - Nomor HP pengunjung (required)
-   `email` - Email pengunjung (required)
-   `rating` - Rating 1-5 (required)
-   `comment` - Komentar/ulasan (optional)
-   `timestamps` - Created at & Updated at

### 2. Files Created/Modified

#### Controllers

-   **ReviewController.php** - Handle review submission
    -   Method: `store()` - Menerima data review, validasi, simpan ke database, kirim email

#### Models

-   **Review.php** - Updated untuk support guest reviews (tanpa user_id)
    -   Fillable: product_id, name, phone, email, rating, comment

#### Mail

-   **ReviewThankYouMail.php** - Email notifikasi ucapan terima kasih
    -   Dikirim otomatis setelah review berhasil disimpan

#### Views

-   **emails/review-thank-you.blade.php** - Template email ucapan terima kasih
    -   Menampilkan: nama reviewer, produk, rating, komentar
    -   Design: Professional dengan gradient header
-   **catalog/show.blade.php** - Updated dengan form review
    -   Section ulasan pembeli
    -   Button "Tulis Ulasan"
    -   Form modal dengan fields: nama, HP, email, rating (1-5), komentar
    -   Auto-show form jika ada validation errors
    -   Auto-hide success message setelah 5 detik

#### Routes

```php
// Public route - tidak perlu login
Route::post('/products/{product:slug}/review', [ReviewController::class, 'store'])
    ->name('review.store');
```

#### Migrations

-   Updated `2025_11_27_023901_add_product_features.php`
    -   Reviews table sekarang menggunakan `name`, `phone`, `email` (tidak ada user_id)
    -   Support untuk guest reviews

### 3. Validasi

-   **Nama**: Required, string, max 255 karakter
-   **Nomor HP**: Required, string, max 20 karakter
-   **Email**: Required, valid email format, max 255 karakter
-   **Rating**: Required, integer, min 1, max 5
-   **Komentar**: Optional, string, max 1000 karakter

### 4. Flow Proses

1. Pengunjung melihat detail produk
2. Klik button "Tulis Ulasan"
3. Form muncul dengan input: nama, HP, email, rating, komentar
4. Submit form
5. Data ter-validasi
6. Review tersimpan di database
7. Email ucapan terima kasih otomatis terkirim ke email pengunjung
8. Redirect ke halaman produk dengan success message
9. Review muncul di section "Ulasan Pembeli"

### 5. Email Notification

Email berisi:

-   Ucapan terima kasih
-   Nama reviewer
-   Nama produk yang direview
-   Rating yang diberikan (dalam bentuk bintang)
-   Komentar (jika ada)
-   Link ke produk
-   Footer PojokKampus

Design: Professional dengan gradient indigo-purple, responsive, dan modern.

### 6. Fitur Tambahan

-   **Auto-expand form**: Form otomatis terbuka jika ada validation errors
-   **Success message**: Auto-hide setelah 5 detik dan scroll ke atas
-   **Rating stars**: Interactive clickable stars (1-5)
-   **Responsive design**: Form responsive untuk mobile dan desktop
-   **Avatar gradient**: Review ditampilkan dengan avatar gradient yang cantik
-   **Empty state**: Pesan "Belum ada ulasan" jika produk belum direview

### 7. Kesesuaian dengan SRS

✅ Pengunjung dapat memberikan komentar dan rating tanpa login
✅ Input data: nama, nomor HP, email (sesuai SRS)
✅ Rating skala 1 sampai 5
✅ Komentar dapat diisi atau dikosongkan
✅ Notifikasi ucapan terima kasih dikirim via email
✅ Review ditampilkan di halaman produk dengan rating dan komentar
✅ Rating rata-rata dihitung dan ditampilkan

## Testing

Untuk testing fitur ini:

1. Akses halaman detail produk: `/products/{slug}`
2. Klik button "Tulis Ulasan"
3. Isi form dengan data valid
4. Klik "Kirim Ulasan"
5. Cek email untuk menerima notifikasi ucapan terima kasih
6. Verifikasi review muncul di halaman produk

## Catatan

-   Email menggunakan queue system (dapat di-enable untuk production)
-   Error sending email tidak akan menggagalkan proses review
-   Semua review akan langsung tampil (tidak ada moderasi)
-   Satu email dapat memberikan multiple reviews untuk produk berbeda
