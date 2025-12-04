<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Seller;
use Illuminate\Support\Facades\Hash;

class TestSellerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Delete existing test seller if exists
        $existingUser = User::where('email', 'seller@test.com')->first();
        if ($existingUser) {
            if ($existingUser->seller) {
                $existingUser->seller->delete();
            }
            $existingUser->delete();
        }

        // Create test seller user
        $user = User::create([
            'name' => 'Test Seller',
            'email' => 'seller@test.com',
            'password' => Hash::make('seller123'),
            'role' => 'seller',
            'status' => 'active',
            'email_verified_at' => now(),
        ]);

        // Create seller profile
        Seller::create([
            'user_id' => $user->id,
            'nama_toko' => 'Toko Test',
            'deskripsi_singkat' => 'Toko untuk testing aplikasi',
            'nama_pic' => 'Test Seller',
            'no_ktp_pic' => '1234567890123456',
            'alamat_ktp_pic' => 'Jl. Test No. 123, Jakarta',
            'email_pic' => 'seller@test.com',
            'alamat' => 'Jl. Test No. 123, Jakarta Pusat',
            'nama_kelurahan' => 'Menteng',
            'kecamatan' => 'Menteng',
            'kabupaten_kota' => 'Jakarta Pusat',
            'provinsi' => 'DKI Jakarta',
            'file_ktp_pic' => null,
            'verification_status' => 'approved',
        ]);

        echo "Test Seller created successfully!\n";
        echo "Email: seller@test.com\n";
        echo "Password: seller123\n";
    }
}
