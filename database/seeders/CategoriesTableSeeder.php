<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('categories')->insert([
            ['name' => 'Skincare', 'description' => 'Beauty products for skin care', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Makeup', 'description' => 'Beauty products for makeup', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Hair Care', 'description' => 'Products for hair treatment', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Vitamins & Supplements', 'description' => 'Health supplements and vitamins', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Medical Equipment', 'description' => 'Equipment for medical use', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Personal Care', 'description' => 'General personal care items', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
    
}
