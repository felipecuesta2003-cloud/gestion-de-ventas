<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Sale;

class SaleSeeder extends Seeder
{
    public function run(): void
    {
        $televisor = Product::where('reference', 'TV-001')->first();
        $nevera = Product::where('reference', 'NEV-001')->first();
        $microondas = Product::where('reference', 'MIC-001')->first();
        $lavadora = Product::where('reference', 'LAV-001')->first();
        $licuadora = Product::where('reference', 'LIC-001')->first();

        Sale::create([
            'product_id' => $televisor->id,
            'quantity' => 2,
            'unit_price' => $televisor->price,
            'total' => 2 * $televisor->price,
        ]);

        Sale::create([
            'product_id' => $nevera->id,
            'quantity' => 1,
            'unit_price' => $nevera->price,
            'total' => 1 * $nevera->price,
        ]);

        Sale::create([
            'product_id' => $microondas->id,
            'quantity' => 3,
            'unit_price' => $microondas->price,
            'total' => 3 * $microondas->price,
        ]);

        Sale::create([
            'product_id' => $lavadora->id,
            'quantity' => 2,
            'unit_price' => $lavadora->price,
            'total' => 2 * $lavadora->price,
        ]);

        Sale::create([
            'product_id' => $licuadora->id,
            'quantity' => 4,
            'unit_price' => $licuadora->price,
            'total' => 4 * $licuadora->price,
        ]);
    }
}