<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $seller = User::where('role', 'seller')->where('status', 'active')->first();

        if (!$seller || !$seller->seller) {
            echo "No active seller found. Please create a seller first.\n";
            return;
        }

        $categories = Category::all();

        if ($categories->isEmpty()) {
            echo "No categories found. Please create categories first.\n";
            return;
        }

        $products = [
            [
                'name' => 'Laptop Gaming ROG Strix',
                'description' => 'Laptop gaming powerful dengan processor Intel Core i7 Gen 12, RAM 16GB, SSD 512GB, RTX 3060. Cocok untuk gaming dan editing video.',
                'price' => 15000000,
                'stock' => 5,
                'brand' => 'ASUS ROG',
                'condition' => 'new',
            ],
            [
                'name' => 'iPhone 13 Pro Max 256GB',
                'description' => 'iPhone 13 Pro Max warna Sierra Blue, kondisi mulus, lengkap dengan box dan charger original. Garansi resmi masih aktif.',
                'price' => 14000000,
                'stock' => 3,
                'brand' => 'Apple',
                'condition' => 'used',
            ],
            [
                'name' => 'Buku Algoritma dan Pemrograman',
                'description' => 'Buku referensi algoritma dan pemrograman untuk mahasiswa teknik informatika. Kondisi sangat baik, tidak ada coretan.',
                'price' => 85000,
                'stock' => 10,
                'brand' => 'Informatika',
                'condition' => 'used',
            ],
            [
                'name' => 'Mechanical Keyboard Keychron K2',
                'description' => 'Keyboard mechanical wireless Keychron K2 dengan switch Gateron Brown. Cocok untuk produktivitas dan gaming.',
                'price' => 1200000,
                'stock' => 8,
                'brand' => 'Keychron',
                'condition' => 'new',
            ],
            [
                'name' => 'Jaket Hoodie Universitas',
                'description' => 'Jaket hoodie dengan logo universitas, bahan cotton fleece premium, tersedia size M, L, XL. Nyaman untuk aktivitas sehari-hari.',
                'price' => 150000,
                'stock' => 20,
                'brand' => 'Custom',
                'condition' => 'new',
            ],
        ];

        foreach ($products as $productData) {
            $slug = Str::slug($productData['name']);

            Product::create([
                'user_id' => $seller->id,
                'category_id' => $categories->random()->id,
                'name' => $productData['name'],
                'slug' => $slug,
                'description' => $productData['description'],
                'price' => $productData['price'],
                'stock' => $productData['stock'],
                'brand' => $productData['brand'] ?? null,
                'condition' => $productData['condition'] ?? 'new',
                'min_order' => 1,
                'status' => 'active',
            ]);
        }

        echo "Created " . count($products) . " products successfully!\n";
    }
}
