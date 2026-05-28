<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed users first (1 admin + 5 customers)
        $this->call(UserSeeder::class);

        // Then seed categories (6 flower categories)
        $this->call(CategorySeeder::class);

        // Finally seed products (18-20 flower products)
        $this->call(ProductSeeder::class);
    }
}
