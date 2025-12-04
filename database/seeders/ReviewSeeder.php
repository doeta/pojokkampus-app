<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Review;
use Faker\Factory as Faker;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $products = Product::all();

        if ($products->isEmpty()) {
            echo "❌ No products found. Please create products first.\n";
            return;
        }

        echo "🔄 Creating random reviews for products...\n";

        $reviewCount = 0;

        // Add 2-5 reviews per product randomly
        foreach ($products as $product) {
            $numReviews = rand(2, 5);

            for ($i = 0; $i < $numReviews; $i++) {
                Review::create([
                    'product_id' => $product->id,
                    'name' => $faker->name,
                    'phone' => $faker->phoneNumber,
                    'email' => $faker->safeEmail,
                    'rating' => rand(3, 5), // Rating 3-5 stars
                    'comment' => $this->getRandomComment($faker),
                ]);

                $reviewCount++;
            }
        }

        echo "✅ Successfully created $reviewCount reviews!\n";
    }

    private function getRandomComment($faker)
    {
        $comments = [
            'Produk bagus, sesuai deskripsi. Packing rapi dan pengiriman cepat!',
            'Kualitas oke banget! Highly recommended untuk yang cari produk berkualitas.',
            'Harga worth it dengan kualitas yang didapat. Seller responsif.',
            'Barang original, packaging bagus. Puas banget belanja disini!',
            'Produk sesuai ekspektasi, pengiriman cepat. Terima kasih!',
            'Mantap jiwa! Barang sampai dengan aman, kualitas premium.',
            'Recommended seller! Fast response dan barang berkualitas tinggi.',
            'Sangat puas dengan pembelian ini. Worth the price!',
            'Barang oke, pengiriman cepat. Next order lagi disini.',
            'Produk original dan berkualitas. Packaging aman dan rapi.',
            'Sesuai gambar dan deskripsi. Seller fast response, recommended!',
            'Kualitas bagus, harga terjangkau. Bakal repeat order!',
            'Produknya mantap, pengiriman juga cepat. Thanks seller!',
            'Memuaskan! Barang sesuai ekspektasi dan kondisi sangat baik.',
            'Top markotop! Barang bagus, harga reasonable, seller friendly.',
            null, // Some reviews without comment
            null,
        ];

        return $faker->randomElement($comments);
    }
}
