<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $colors = [
            [
                'name' => 'Red',
                'description' => 'Red',
                'hex_code' => '#FF0000',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Green',
                'description' => 'Green',
                'hex_code' => '#00FF00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Blue',
                'description' => 'Blue',
                'hex_code' => '#0000FF',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('product_colors')->insert($colors);
    }
}
