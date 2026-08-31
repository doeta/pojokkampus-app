<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Elektronik', 'slug' => 'elektronik', 'icon' => '📱', 'description' => 'Handphone, laptop, dan elektronik lainnya'],
            ['name' => 'Fashion', 'slug' => 'fashion', 'icon' => '👕', 'description' => 'Pakaian, sepatu, dan aksesoris'],
            ['name' => 'Makanan & Minuman', 'slug' => 'makanan-minuman', 'icon' => '🍔', 'description' => 'Makanan, minuman, dan kebutuhan dapur'],
            ['name' => 'Kesehatan', 'slug' => 'kesehatan', 'icon' => '💊', 'description' => 'Produk kesehatan dan kecantikan'],
            ['name' => 'Rumah Tangga', 'slug' => 'rumah-tangga', 'icon' => '🏠', 'description' => 'Peralatan dan perlengkapan rumah'],
            ['name' => 'Olahraga', 'slug' => 'olahraga', 'icon' => '⚽', 'description' => 'Peralatan olahraga dan outdoor'],
            ['name' => 'Buku & Alat Tulis', 'slug' => 'buku-alat-tulis', 'icon' => '📚', 'description' => 'Buku, alat tulis, dan edukasi'],
            ['name' => 'Mainan & Hobi', 'slug' => 'mainan-hobi', 'icon' => '🎮', 'description' => 'Mainan anak dan hobi'],
        ];

        foreach ($categories as $category) {
            \App\Models\Category::firstOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }
    }
}
