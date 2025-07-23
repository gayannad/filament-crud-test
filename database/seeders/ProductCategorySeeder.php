<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('product_categories')->insert([
            [
                'name' => 'CAT1',
                'description' => 'CAT1',
                'external_url' => 'https://example.com/cat1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'CAT2',
                'description' => 'CAT2',
                'external_url' => 'https://example.com/cat2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'CAT3',
                'description' => 'CAT3',
                'external_url' => 'https://example.com/cat3',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
