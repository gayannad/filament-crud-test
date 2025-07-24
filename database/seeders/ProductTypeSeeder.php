<?php

namespace Database\Seeders;

use App\Services\ProductTypeService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $service = new ProductTypeService;

        $types = [
            [
                'name' => 'TYPE1',
                'api_unique_number' => $service->fetchUniqueNumber('TYPE1'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'TYPE2',
                'api_unique_number' => $service->fetchUniqueNumber('TYPE2'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'TYPE3',
                'api_unique_number' => $service->fetchUniqueNumber('TYPE3'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('product_types')->insert($types);
    }
}
