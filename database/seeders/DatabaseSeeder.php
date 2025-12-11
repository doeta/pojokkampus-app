<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Run all seeders
        $this->call([
            AdminSeeder::class,
            PlatformUserSeeder::class,
            CategorySeeder::class,
            TestSellerSeeder::class,
            ProductSeeder::class,
            ProductWithImagesSeeder::class,
            ReviewSeeder::class,
        ]);
    }
}
