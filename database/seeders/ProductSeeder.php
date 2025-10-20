<?php

namespace Database\Seeders;

use App\Models\Plant;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plant = Plant::first();

        Product::create([
            'uuid' => Str::uuid(),
            'brand' => 'Fiesta',
            'product_name' => 'Chicken Sausage',
            'nett_weight' => '400',
            'shelf_life' => 6,
            'plant_uuid' => $plant->uuid,
        ]);
    }
}
