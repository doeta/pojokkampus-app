<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

class ProductWithImagesSeeder extends Seeder
{
    public function run(): void
    {
        $seller = User::where('email', 'seller@test.com')->first();

        if (!$seller || !$seller->seller) {
            echo "❌ Test seller not found. Please run TestSellerSeeder first.\n";
            return;
        }

        $categories = Category::all();

        if ($categories->isEmpty()) {
            echo "❌ No categories found. Please create categories first.\n";
            return;
        }

        echo "🔄 Creating 50 products with images...\n";

        // Ensure product-images directory exists
        if (!Storage::disk('public')->exists('product-images')) {
            Storage::disk('public')->makeDirectory('product-images');
        }

        $productsData = $this->getProductsData();

        foreach ($productsData as $index => $productData) {
            try {
                // Get random category
                $category = $categories->random();

                // Download placeholder image
                $imageUrl = $this->getPlaceholderImage($category->name, $index);
                $imagePath = $this->downloadImage($imageUrl, $index);

                $product = Product::create([
                    'user_id' => $seller->id,
                    'category_id' => $category->id,
                    'name' => $productData['name'],
                    'slug' => Str::slug($productData['name']) . '-' . Str::random(6),
                    'description' => $productData['description'],
                    'price' => $productData['price'],
                    'stock' => $productData['stock'],
                    'brand' => $productData['brand'],
                    'condition' => $productData['condition'],
                    'image' => $imagePath,
                    'status' => 'active',
                ]);

                $num = $index + 1;
                echo "✓ [$num/50] Created: {$product->name} ({$category->name})\n";
            } catch (\Exception $e) {
                $num = $index + 1;
                echo "✗ [$num/50] Error: {$e->getMessage()}\n";
            }
        }

        echo "\n✅ Successfully created 50 products with images!\n";
    }

    private function downloadImage($url, $index)
    {
        try {
            $response = Http::timeout(10)->get($url);

            if ($response->successful()) {
                $filename = 'product-' . time() . '-' . $index . '.jpg';
                $path = 'product-images/' . $filename;
                Storage::disk('public')->put($path, $response->body());
                return $path;
            }
        } catch (\Exception $e) {
            // Fallback to placeholder if download fails
        }

        // Return null if image download fails
        return null;
    }

    private function getPlaceholderImage($categoryName, $seed)
    {
        // Use picsum.photos for placeholder images with seed for consistency
        return "https://picsum.photos/seed/product{$seed}/800/600";
    }

    private function getProductsData()
    {
        return [
            // Elektronik (10 produk)
            ['name' => 'Laptop ASUS TUF Gaming F15', 'description' => 'Laptop gaming dengan Intel Core i7 Gen 12, RTX 3050, RAM 16GB DDR4, SSD 512GB. Perfect untuk gaming dan multitasking.', 'price' => 13500000, 'stock' => 8, 'brand' => 'ASUS', 'condition' => 'new'],
            ['name' => 'iPhone 14 Pro 128GB', 'description' => 'iPhone 14 Pro warna Deep Purple, kondisi like new, fullset box. Dynamic Island, kamera 48MP, Always-On Display.', 'price' => 16500000, 'stock' => 4, 'brand' => 'Apple', 'condition' => 'used'],
            ['name' => 'Samsung Galaxy S23 Ultra', 'description' => 'Flagship Samsung dengan S-Pen, kamera 200MP, Snapdragon 8 Gen 2, RAM 12GB, storage 256GB. Garansi resmi.', 'price' => 15000000, 'stock' => 6, 'brand' => 'Samsung', 'condition' => 'new'],
            ['name' => 'iPad Air M1 64GB WiFi', 'description' => 'iPad Air generasi terbaru dengan chip M1, layar 10.9 inch Liquid Retina, support Apple Pencil Gen 2.', 'price' => 8500000, 'stock' => 10, 'brand' => 'Apple', 'condition' => 'new'],
            ['name' => 'Sony WH-1000XM5 Headphone', 'description' => 'Headphone noise cancelling terbaik di kelasnya, audio quality premium, battery life 30 jam, nyaman untuk long session.', 'price' => 4500000, 'stock' => 15, 'brand' => 'Sony', 'condition' => 'new'],
            ['name' => 'MacBook Air M2 2023', 'description' => 'MacBook Air terbaru dengan chip M2, RAM 8GB, SSD 256GB, layar Liquid Retina 13.6 inch. Thin & powerful.', 'price' => 18000000, 'stock' => 5, 'brand' => 'Apple', 'condition' => 'new'],
            ['name' => 'Logitech MX Master 3S Mouse', 'description' => 'Mouse wireless premium untuk produktivitas, sensor 8K DPI, silent click, battery 70 hari, multi-device.', 'price' => 1200000, 'stock' => 20, 'brand' => 'Logitech', 'condition' => 'new'],
            ['name' => 'Keychron K2 Mechanical Keyboard', 'description' => 'Keyboard mechanical wireless 75%, hotswap switch, RGB backlight, compatible Mac & Windows, Gateron Brown.', 'price' => 1500000, 'stock' => 12, 'brand' => 'Keychron', 'condition' => 'new'],
            ['name' => 'Samsung 34" Curved Monitor', 'description' => 'Monitor curved ultrawide 34 inch, resolusi WQHD 3440x1440, refresh rate 100Hz, perfect untuk multitasking.', 'price' => 6500000, 'stock' => 7, 'brand' => 'Samsung', 'condition' => 'new'],
            ['name' => 'Anker PowerBank 20000mAh', 'description' => 'PowerBank kapasitas besar 20000mAh, support fast charging PD 18W, dual USB port, portable dan reliable.', 'price' => 450000, 'stock' => 30, 'brand' => 'Anker', 'condition' => 'new'],

            // Fashion (10 produk)
            ['name' => 'Jaket Bomber Premium Unisex', 'description' => 'Jaket bomber berkualitas tinggi, bahan polyester tebal, waterproof, tersedia size M-XXL, warna hitam & navy.', 'price' => 350000, 'stock' => 25, 'brand' => 'LocalBrand', 'condition' => 'new'],
            ['name' => 'Sepatu Nike Air Force 1', 'description' => 'Sneakers iconic Nike AF1, colorway Triple White, original guaranteed, size 40-44, box included.', 'price' => 1500000, 'stock' => 15, 'brand' => 'Nike', 'condition' => 'new'],
            ['name' => 'Tas Ransel Anti Maling USB Port', 'description' => 'Tas ransel laptop 15.6 inch, fitur anti-theft, built-in USB charging port, bahan water resistant, banyak slot.', 'price' => 280000, 'stock' => 40, 'brand' => 'UrbanGear', 'condition' => 'new'],
            ['name' => 'Kacamata Ray-Ban Aviator', 'description' => 'Kacamata klasik Ray-Ban Aviator, lensa UV protection, frame metal gold, include hardcase & cleaning cloth.', 'price' => 2200000, 'stock' => 8, 'brand' => 'Ray-Ban', 'condition' => 'new'],
            ['name' => 'Jam Tangan Casio G-Shock', 'description' => 'G-Shock GA-2100 CasiOak, shock resistant, water resistant 200m, digital-analog, style & tough.', 'price' => 1800000, 'stock' => 12, 'brand' => 'Casio', 'condition' => 'new'],
            ['name' => 'Hoodie Oversized Cotton Premium', 'description' => 'Hoodie oversized cotton fleece 320gsm, super soft & warm, tersedia berbagai warna, unisex fit, size M-XL.', 'price' => 250000, 'stock' => 35, 'brand' => 'StreetwearCo', 'condition' => 'new'],
            ['name' => 'Celana Jeans Levis 501 Original', 'description' => 'Jeans Levis 501 original fit, bahan denim premium, warna dark indigo, iconic button fly, size 28-36.', 'price' => 950000, 'stock' => 18, 'brand' => 'Levis', 'condition' => 'new'],
            ['name' => 'Topi Baseball Cap Polos', 'description' => 'Topi baseball cap polos premium, bahan katun, adjustable strap, simple & stylish, tersedia 8 warna.', 'price' => 75000, 'stock' => 50, 'brand' => 'BasicWear', 'condition' => 'new'],
            ['name' => 'Dompet Kulit RFID Protection', 'description' => 'Dompet pria kulit asli dengan RFID blocking, banyak slot kartu, slim design, warna coklat & hitam.', 'price' => 180000, 'stock' => 22, 'brand' => 'LeatherCraft', 'condition' => 'new'],
            ['name' => 'Sabuk Kulit Premium Reversible', 'description' => 'Sabuk kulit sapi asli, reversible black & brown, buckle stainless steel, panjang adjustable 110-125cm.', 'price' => 220000, 'stock' => 20, 'brand' => 'ClassicWear', 'condition' => 'new'],

            // Buku & Alat Tulis (10 produk)
            ['name' => 'Buku "Atomic Habits" James Clear', 'description' => 'Buku bestseller internasional tentang membangun kebiasaan baik dan menghilangkan kebiasaan buruk. Soft cover bahasa Indonesia.', 'price' => 95000, 'stock' => 30, 'brand' => 'Gramedia', 'condition' => 'new'],
            ['name' => 'Algoritma & Struktur Data Python', 'description' => 'Buku panduan lengkap algoritma dan struktur data menggunakan Python, cocok untuk mahasiswa dan programmer pemula.', 'price' => 125000, 'stock' => 20, 'brand' => 'Informatika', 'condition' => 'new'],
            ['name' => 'Notebook Moleskine Classic', 'description' => 'Notebook premium hardcover, kertas tebal 80gsm, elastic closure, pocket di belakang, ukuran large ruled.', 'price' => 280000, 'stock' => 15, 'brand' => 'Moleskine', 'condition' => 'new'],
            ['name' => 'Pilot FriXion Erasable Pen Set', 'description' => 'Set 12 pulpen hapus Pilot FriXion, tinta gel erasable, tidak meninggalkan bekas, warna-warni lengkap.', 'price' => 120000, 'stock' => 25, 'brand' => 'Pilot', 'condition' => 'new'],
            ['name' => 'Stabilo Boss Highlighter 8 Colors', 'description' => 'Set 8 highlighter Stabilo Boss, warna pastel & neon, anti-dry out 4 jam, tip lebar 2-5mm, water based ink.', 'price' => 85000, 'stock' => 40, 'brand' => 'Stabilo', 'condition' => 'new'],
            ['name' => 'Buku "The Psychology of Money"', 'description' => 'Buku tentang psikologi keuangan dan investasi, mengubah mindset tentang uang dan wealth building.', 'price' => 98000, 'stock' => 28, 'brand' => 'Gramedia', 'condition' => 'new'],
            ['name' => 'Staedtler Pensil 2B Set 12pcs', 'description' => 'Pensil grafit Staedtler Mars Lumograph 2B, kualitas premium, break-resistant, set 12 batang + eraser.', 'price' => 65000, 'stock' => 35, 'brand' => 'Staedtler', 'condition' => 'new'],
            ['name' => 'Post-it Sticky Notes Assorted', 'description' => 'Paket hemat 12 pad Post-it sticky notes berbagai ukuran dan warna, super sticky, repositionable.', 'price' => 75000, 'stock' => 45, 'brand' => '3M Post-it', 'condition' => 'new'],
            ['name' => 'Binder Clip Joyko Set 100pcs', 'description' => 'Binder clip Joyko berbagai ukuran (19mm-51mm), bahan baja anti karat, grip kuat, box plastik praktis.', 'price' => 45000, 'stock' => 50, 'brand' => 'Joyko', 'condition' => 'new'],
            ['name' => 'Penggaris Set Butterfly + Busur', 'description' => 'Set penggaris lengkap: penggaris 30cm, segitiga 2 buah, busur derajat, bahan plastik transparan kuat.', 'price' => 25000, 'stock' => 60, 'brand' => 'Butterfly', 'condition' => 'new'],

            // Makanan & Minuman (10 produk)
            ['name' => 'Kopi Arabica Gayo Premium 250gr', 'description' => 'Kopi single origin dari Gayo Aceh, roasted medium, notes chocolate & fruity, kemasan ziplock vakum.', 'price' => 85000, 'stock' => 40, 'brand' => 'GayoCoffee', 'condition' => 'new'],
            ['name' => 'Matcha Powder Jepang 100gr', 'description' => 'Matcha powder grade premium dari Jepang, organik, untuk latte/baking, antioksidan tinggi, kemasan sealed.', 'price' => 125000, 'stock' => 25, 'brand' => 'Kyoto Matcha', 'condition' => 'new'],
            ['name' => 'Mie Instan Indomie Goreng 30pcs', 'description' => 'Paket hemat Indomie Goreng original, rasa favorit Indonesia, cocok untuk stok bulanan, expired panjang.', 'price' => 90000, 'stock' => 50, 'brand' => 'Indomie', 'condition' => 'new'],
            ['name' => 'Coklat Silverqueen Chunky Bar 6pcs', 'description' => 'Coklat Silverqueen Chunky Bar aneka rasa, 6 batang dalam 1 paket, cocok untuk gift atau stok pribadi.', 'price' => 72000, 'stock' => 45, 'brand' => 'Silverqueen', 'condition' => 'new'],
            ['name' => 'Susu UHT Ultra Milk Full Cream 12pcs', 'description' => 'Susu UHT Ultra Milk Full Cream 250ml, paket 12 kotak, kalsium tinggi, tanpa pengawet, praktis & bergizi.', 'price' => 58000, 'stock' => 60, 'brand' => 'Ultra Milk', 'condition' => 'new'],
            ['name' => 'Madu Hutan Liar Murni 500ml', 'description' => 'Madu hutan liar 100% murni dari hutan Kalimantan, tanpa campuran, kaya manfaat kesehatan, botol kaca.', 'price' => 150000, 'stock' => 20, 'brand' => 'MaduAsli', 'condition' => 'new'],
            ['name' => 'Green Tea Dilmah 100 Tea Bags', 'description' => 'Green tea Dilmah premium quality, 100 kantong teh, antioksidan tinggi, rasa smooth & refreshing.', 'price' => 95000, 'stock' => 30, 'brand' => 'Dilmah', 'condition' => 'new'],
            ['name' => 'Keripik Singkong Pedas Manis 500gr', 'description' => 'Keripik singkong homemade rasa pedas manis, kriuk, tidak keras, kemasan vakum, tahan 2 bulan.', 'price' => 35000, 'stock' => 70, 'brand' => 'SnackMama', 'condition' => 'new'],
            ['name' => 'Kacang Mete Mede Premium 250gr', 'description' => 'Kacang mete premium grade A, original tanpa perasa, fresh & crunchy, kemasan ziplock, perfect untuk snack.', 'price' => 85000, 'stock' => 35, 'brand' => 'NutsPremium', 'condition' => 'new'],
            ['name' => 'Selai Kacang Skippy Creamy 510gr', 'description' => 'Selai kacang Skippy creamy original USA, kaya protein, cocok untuk roti/smoothie bowl, jar besar 510gr.', 'price' => 78000, 'stock' => 28, 'brand' => 'Skippy', 'condition' => 'new'],

            // Olahraga (10 produk)
            ['name' => 'Matras Yoga Premium 6mm', 'description' => 'Matras yoga NBR 6mm tebal, anti-slip, empuk & nyaman, dengan carrying bag, ukuran 183x61cm, warna pilihan.', 'price' => 150000, 'stock' => 30, 'brand' => 'YogaPro', 'condition' => 'new'],
            ['name' => 'Dumbbell Set 20kg Adjustable', 'description' => 'Dumbbell adjustable 20kg (2x10kg), besi berlapis vinyl, berat bisa diatur, cocok untuk home gym.', 'price' => 380000, 'stock' => 15, 'brand' => 'FitnessPro', 'condition' => 'new'],
            ['name' => 'Resistance Band Set 5 Level', 'description' => 'Set 5 resistance band berbeda level resistance, dengan handle & anchor, portable, cocok untuk workout di rumah.', 'price' => 120000, 'stock' => 40, 'brand' => 'BandFit', 'condition' => 'new'],
            ['name' => 'Jersey Futsal Printing Custom', 'description' => 'Jersey futsal printing bahan drifit, custom nama & nomor, nyaman & breathable, size S-XXL, min order 1pcs.', 'price' => 85000, 'stock' => 100, 'brand' => 'SportWear', 'condition' => 'new'],
            ['name' => 'Sepatu Lari Adidas Ultraboost', 'description' => 'Sepatu lari Adidas Ultraboost 22, boost midsole, primeknit upper, grip optimal, size 39-44, original.', 'price' => 2400000, 'stock' => 8, 'brand' => 'Adidas', 'condition' => 'new'],
            ['name' => 'Botol Minum Olahraga 1L BPA Free', 'description' => 'Botol minum sport 1 liter, BPA free, anti-spill, dilengkapi time marker, cocok untuk gym/outdoor.', 'price' => 65000, 'stock' => 50, 'brand' => 'HydroFit', 'condition' => 'new'],
            ['name' => 'Skipping Rope Speed Jump Rope', 'description' => 'Skipping rope bearing ball system, adjustable length, counter digital, grip anti-slip, cocok untuk cardio.', 'price' => 75000, 'stock' => 45, 'brand' => 'JumpPro', 'condition' => 'new'],
            ['name' => 'Sarung Tangan Gym Half Finger', 'description' => 'Sarung tangan gym half finger, padding tebal, breathable mesh, wrist support, proteksi maksimal saat workout.', 'price' => 85000, 'stock' => 35, 'brand' => 'GymGear', 'condition' => 'new'],
            ['name' => 'Bola Futsal Specs Original Size 4', 'description' => 'Bola futsal Specs original size 4, jahitan rapi, bouncing bagus, tahan lama, untuk latihan & pertandingan.', 'price' => 280000, 'stock' => 20, 'brand' => 'Specs', 'condition' => 'new'],
            ['name' => 'Push Up Bar Stand Foam Grip', 'description' => 'Push up bar dengan foam grip nyaman, stable base, meningkatkan intensitas push up, portable & durable.', 'price' => 95000, 'stock' => 40, 'brand' => 'FitTools', 'condition' => 'new'],
        ];
    }
}
