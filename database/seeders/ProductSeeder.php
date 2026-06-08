<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::create([
            'name' => 'Quest of Code Masters',
            'type' => 'game',
            'link' => 'https://kelompok-anda.itch.io/quest-of-code',
            'price' => 5000,
        ]);

        Product::create([
            'name' => 'Aplikasi Sewa Android',
            'type' => 'android',
            'link' => 'https://github.com/kelompok-anda/android-app',
            'price' => 10000,
        ]);
    }
}