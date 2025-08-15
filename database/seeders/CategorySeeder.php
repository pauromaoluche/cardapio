<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::insert([
            [
                'name' => 'Lanches',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Pasteis',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Bebidas',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Porções',
                'created_at' => now(),
                'updated_at' => now(),
            ],
                        [
                'name' => 'Sobremesas',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
