<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::query()->delete();
        
        Product::create([
            'name' => 'Televisor',
            'reference' => 'TV-001',
            'price' => 1500000,
        ]);

        Product::create([
            'name' => 'Nevera',
            'reference' => 'NEV-001',
            'price' => 3000000,
        ]);

        Product::create([
            'name' => 'Microondas',
            'reference' => 'MIC-001',
            'price' => 500000,
        ]);

        Product::create([
            'name' => 'Lavadora',
            'reference' => 'LAV-001',
            'price' => 2200000,
        ]);

        Product::create([
            'name' => 'Licuadora',
            'reference' => 'LIC-001',
            'price' => 350000,
        ]);
    }
}