<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\SellerController as AdminSellerController;
use App\Http\Controllers\Seller\DashboardController as SellerDashboardController;
use App\Http\Controllers\Seller\ProductController as SellerProductController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SellerRegistrationController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('welcome');

// Public Catalog Routes
Route::get('/products', [CatalogController::class, 'index'])->name('catalog.index');
Route::get('/p/{category:slug}', [CatalogController::class, 'indexByCategory'])->name('catalog.category');
Route::get('/products/{product:slug}', [CatalogController::class, 'show'])->name('catalog.show');

// Review Routes (SRS-MartPlace-06) - Public, no login required
Route::post('/products/{product:slug}/review', [ReviewController::class, 'store'])->name('review.store');

// Seller Registration Routes (Public)
Route::get('/register-seller', [SellerRegistrationController::class, 'create'])->name('seller.register.form');
Route::post('/register-seller', [SellerRegistrationController::class, 'store'])->name('seller.register');
Route::get('/register-seller/success', [SellerRegistrationController::class, 'success'])->name('seller.registration.success');

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Seller Verification (SRS-MartPlace-02)
    Route::get('/sellers/pending', [AdminSellerController::class, 'pending'])->name('sellers.pending');
    Route::get('/sellers/verified', [AdminSellerController::class, 'verified'])->name('sellers.verified');
    Route::get('/sellers', [AdminSellerController::class, 'index'])->name('sellers.index');
    Route::get('/sellers/{seller}', [AdminSellerController::class, 'show'])->name('sellers.show');
    Route::post('/sellers/{seller}/approve', [AdminSellerController::class, 'approve'])->name('sellers.approve');
    Route::post('/sellers/{seller}/reject', [AdminSellerController::class, 'reject'])->name('sellers.reject');
    Route::post('/sellers/{seller}/suspend', [AdminSellerController::class, 'suspend'])->name('sellers.suspend');
    Route::post('/sellers/{seller}/activate', [AdminSellerController::class, 'activate'])->name('sellers.activate');

    // Reports (SRS-MartPlace-09, 10)
    Route::get('/reports/seller-accounts', [App\Http\Controllers\Admin\ReportController::class, 'sellerAccounts'])->name('reports.seller-accounts');
    Route::get('/reports/seller-accounts/pdf', [App\Http\Controllers\Admin\ReportController::class, 'sellerAccountsPdf'])->name('reports.seller-accounts.pdf');
    Route::get('/reports/store-distribution', [App\Http\Controllers\Admin\ReportController::class, 'storeDistribution'])->name('reports.store-distribution');
    Route::get('/reports/store-distribution/pdf', [App\Http\Controllers\Admin\ReportController::class, 'storeDistributionPdf'])->name('reports.store-distribution.pdf');
});

// Seller Routes
Route::middleware(['auth', 'role:seller'])->prefix('seller')->name('seller.')->group(function () {
    Route::get('/dashboard', [SellerDashboardController::class, 'index'])->name('dashboard');

    // Product Management (SRS-MartPlace-03)
    Route::resource('products', SellerProductController::class);

    // Reports (SRS-MartPlace-11, 12, 13, 14)
    // SRS-11: Laporan Produk Berdasarkan Rating
    Route::get('/reports/rating', [\App\Http\Controllers\Seller\ReportController::class, 'rating'])->name('reports.rating');
    Route::get('/reports/rating/pdf', [\App\Http\Controllers\Seller\ReportController::class, 'ratingPdf'])->name('reports.rating.pdf');

    // SRS-12: Laporan Produk Berdasarkan Stock
    Route::get('/reports/stock', [\App\Http\Controllers\Seller\ReportController::class, 'stock'])->name('reports.stock');
    Route::get('/reports/stock/pdf', [\App\Http\Controllers\Seller\ReportController::class, 'stockPdf'])->name('reports.stock.pdf');

    // SRS-13: Laporan Produk Berdasarkan Rating (for seller's own products)
    Route::get('/reports/performance', [\App\Http\Controllers\Seller\ReportController::class, 'performance'])->name('reports.performance');
    Route::get('/reports/performance/pdf', [\App\Http\Controllers\Seller\ReportController::class, 'performancePdf'])->name('reports.performance.pdf');

    // SRS-14: Laporan Produk Segera Dipesan
    Route::get('/reports/restock', [\App\Http\Controllers\Seller\ReportController::class, 'restock'])->name('reports.restock');
    Route::get('/reports/restock/pdf', [\App\Http\Controllers\Seller\ReportController::class, 'restockPdf'])->name('reports.restock.pdf');
}); // Auth Routes (fallback dashboard)
Route::get('/dashboard', function () {
    /** @var \App\Models\User $user */
    $user = Auth::user();

    if (! $user) {
        return redirect()->route('welcome');
    }

    if ($user->isAdmin()) {
        return redirect()->route('admin.dashboard');
    } elseif ($user->isSeller()) {
        return redirect()->route('seller.dashboard');
    }

    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
