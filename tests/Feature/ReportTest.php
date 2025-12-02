<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Seller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReportTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Create a category for products
        Category::create(['name' => 'Electronics', 'slug' => 'electronics']);
    }

    public function test_admin_can_download_seller_accounts_report()
    {
        $admin = User::factory()->create(['role' => 'admin', 'status' => 'active']);

        $response = $this->actingAs($admin)
            ->get(route('admin.reports.seller-accounts'));

        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/pdf');
    }

    public function test_admin_can_download_sellers_by_province_report()
    {
        $admin = User::factory()->create(['role' => 'admin', 'status' => 'active']);

        $response = $this->actingAs($admin)
            ->get(route('admin.reports.sellers-by-province'));

        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/pdf');
    }

    public function test_admin_can_download_products_by_rating_report()
    {
        $admin = User::factory()->create(['role' => 'admin', 'status' => 'active']);

        $response = $this->actingAs($admin)
            ->get(route('admin.reports.products-by-rating'));

        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/pdf');
    }

    public function test_seller_can_download_stock_report()
    {
        $user = User::factory()->create(['role' => 'seller', 'status' => 'active']);
        $seller = Seller::create([
            'user_id' => $user->id,
            'nama_toko' => 'Test Shop',
            'nama_pic' => 'Test PIC',
            'no_ktp_pic' => '1234567890123456',
            'alamat_ktp_pic' => 'Test Address',
            'email_pic' => 'pic@test.com',
            'alamat' => 'Shop Address',
            'nama_kelurahan' => 'Kelurahan',
            'kecamatan' => 'Kecamatan',
            'kabupaten_kota' => 'Kota',
            'provinsi' => 'Provinsi',
            'verification_status' => 'approved'
        ]);

        $response = $this->actingAs($user)
            ->get(route('seller.reports.stock'));

        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/pdf');
    }

    public function test_seller_can_download_stock_by_rating_report()
    {
        $user = User::factory()->create(['role' => 'seller', 'status' => 'active']);
        // Need seller profile for some logic if any, but middleware checks role
        
        $response = $this->actingAs($user)
            ->get(route('seller.reports.stock-by-rating'));

        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/pdf');
    }

    public function test_seller_can_download_urgent_stock_report()
    {
        $user = User::factory()->create(['role' => 'seller', 'status' => 'active']);
        
        $response = $this->actingAs($user)
            ->get(route('seller.reports.urgent-stock'));

        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/pdf');
    }

    public function test_unauthorized_users_cannot_access_reports()
    {
        $user = User::factory()->create(['role' => 'buyer', 'status' => 'active']);

        $response = $this->actingAs($user)
            ->get(route('admin.reports.seller-accounts'));
        $response->assertForbidden();

        $response = $this->actingAs($user)
            ->get(route('seller.reports.stock'));
        $response->assertForbidden();
    }
}
