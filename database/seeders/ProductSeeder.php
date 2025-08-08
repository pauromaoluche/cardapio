<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            'X-Burguer',
            'X-Salada',
            'X-Bacon',
            'X-Tudo',
            'Cachorro-Quente',
            'Misto Quente',
            'Hambúrguer Simples',
            'Cheeseburguer',
            'Batata Frita Pequena',
            'Batata Frita Grande',
            'Batata com Cheddar e Bacon',
            'Anéis de Cebola',
            'Nuggets de Frango',
            'Refrigerante Lata',
            'Refrigerante 600ml',
            'Suco Natural Laranja',
            'Suco Natural Maracujá',
            'Milkshake Chocolate',
            'Milkshake Morango',
            'Milkshake Baunilha',
            'Água Mineral Sem Gás',
            'Água Mineral Com Gás',
            'Açaí no Copo',
            'Açaí na Tigela',
            'Pastel de Carne',
            'Pastel de Queijo',
            'Pastel de Frango',
            'Hot Dog Duplo',
            'Pizza Brotinho Mussarela',
            'Pizza Brotinho Calabresa'
        ];

        foreach ($products as $product) {
            Product::create([
                'name' => $product,
                'description' => fake()->sentence(),
                'price' => fake()->randomFloat(2, 5, 50),
            ]);
        }
    }
}
