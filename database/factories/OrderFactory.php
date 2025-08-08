<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'client_name' => fake()->name(),
            'client_phone' => fake()->phoneNumber(),
            'address' => fake()->address(),
            'total_value' => 0,
            'delivery_fee' => fake()->randomFloat(2, 5, 15),
            'payment_type' => fake()->randomElement(['dinheiro', 'cartão de crédito', 'pix']),
            'change_to' => fake()->randomElement([null, 50, 100]),
            'status_id' => rand(1, 4)
        ];
    }

    public function sequential(int $index): static
    {
        return $this->state(function (array $attributes) use ($index) {
            $baseTime = now()->subHours(3);
            $createdAt = $baseTime->addMinutes($index * 4);

            return [
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ];
        });
    }

    public function configure(): static
    {
        return $this->afterCreating(function (Order $order) {
            // Pega de 1 a 3 produtos aleatórios
            $products = Product::inRandomOrder()->limit(rand(1, 5))->get();
            $attachData = [];
            $totalValue = 0;

            $attachData = [];
            foreach ($products as $product) {
                $quantity = rand(1, 3);
                $attachData[$product->id] = [
                    'quantity' => $quantity,
                    'observation' => rand(0, 1) ? fake()->sentence(3) : null,
                ];
                $totalValue += $product->price * $quantity;
            }

            $totalValue += $order->delivery_fee;

            $order->products()->attach($attachData);

            // Anexa os produtos ao pedido com os dados da tabela pivô
            $order->update(['total_value' => $totalValue]);
        });
    }
}
