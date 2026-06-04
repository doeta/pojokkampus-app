<?php

use App\Models\Seller;
use App\Models\User;
use App\Notifications\SellerVerificationNotification;
use Illuminate\Support\Facades\Notification;

test('admin can approve seller registration and send notification', function () {
    // Fake the notification system
    Notification::fake();

    // Create an admin user (role = 'admin')
    $admin = User::factory()->create([
        'role' => 'admin',
        'status' => 'active',
    ]);

    // Create a pending seller user
    $sellerUser = User::factory()->create([
        'role' => 'seller',
        'status' => 'pending',
    ]);

    // Create a pending seller record associated with the user
    $seller = Seller::create([
        'user_id' => $sellerUser->id,
        'nama_toko' => 'Test Store',
        'deskripsi_singkat' => 'A test store description',
        'nama_pic' => 'Test PIC',
        'no_ktp_pic' => '1234567890123456',
        'alamat_ktp_pic' => 'Test Address',
        'email_pic' => 'pic@test.com',
        'alamat' => 'Test Address',
        'nama_kelurahan' => 'Test Kelurahan',
        'kecamatan' => 'Test Kecamatan',
        'kabupaten_kota' => 'Test Kota',
        'provinsi' => 'Test Provinsi',
        'file_ktp_pic' => 'test_ktp.jpg',
        'verification_status' => 'pending',
    ]);

    // Authenticate as admin and send the approve request via POST
    $response = $this->actingAs($admin)->post(route('admin.sellers.approve', $sellerUser));

    // Assert the response redirects back
    $response->assertRedirect();
    $response->assertSessionHas('success');

    // Assert that the notification was sent to the seller user
    Notification::assertSentTo(
        [$sellerUser], SellerVerificationNotification::class
    );

    // Refresh the models and assert the changes
    $seller->refresh();
    $sellerUser->refresh();

    $this->assertEquals('approved', $seller->verification_status);
    $this->assertEquals('active', $sellerUser->status);
});
