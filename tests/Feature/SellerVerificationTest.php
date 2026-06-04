<?php

use App\Models\Seller;
use App\Models\User;
use App\Notifications\SellerVerificationNotification;
use Illuminate\Support\Facades\Notification;

test('admin can approve seller registration and send notification', function () {
    Notification::fake();

    // Create an admin user (role = 'admin')
    $admin = User::factory()->create([
        'role' => 'admin',
        'status' => 'active',
    ]);


    $sellerUser = User::factory()->create([
        'role' => 'seller',
        'status' => 'pending',
    ]);


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


    $response = $this->actingAs($admin)->post(route('admin.sellers.approve', $sellerUser));

    $response->assertRedirect();
    $response->assertSessionHas('success');


    Notification::assertSentTo(
        [$sellerUser], SellerVerificationNotification::class
    );


    $seller->refresh();
    $sellerUser->refresh();

    $this->assertEquals('approved', $seller->verification_status);
    $this->assertEquals('active', $sellerUser->status);
});
