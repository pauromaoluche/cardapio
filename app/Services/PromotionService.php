<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Promotion;
use App\Traits\ImageHandling;
use Illuminate\Database\Eloquent\Collection;

class PromotionService
{
    use ImageHandling;

    public function getAll(): Collection
    {
        return Promotion::with('images')->get();
    }

    public function findById($id)
    {
        return Promotion::with(['images', 'products'])->where('id', $id)->firstOrFail();
    }

    public function store(array $data, array $products): Promotion
    {
        $instance = Promotion::create($data);

        $attachData = [];
        foreach ($products as $item) {
            $product = Product::find($item['id']);
            if ($product) {
                $attachData[$product->id] = ['quantity' => $item['quantity'] ?? 1];
            }
        }

        if (!empty($attachData)) {
            $instance->products()->attach($attachData);
        }

        $this->handleImages($instance, $data['images'], [], 'promotion');

        return $instance;
    }

    public function update(int $id, array $data, array $products, array $imagesToRemove): bool
    {
        $instance = Promotion::findOrFail($id);

        $updated = $instance->update($data);

        // Monta o array para sync
        $attachData = [];
        foreach ($products as $item) {
            $product = Product::find($item['id']);
            if ($product) {
                $attachData[$product->id] = ['quantity' => $item['quantity'] ?? 1];
            }
        }

        // Atualiza o pivot (remove e adiciona conforme necessário)
        $instance->products()->sync($attachData);

        $this->handleImages($instance, $data['images'], $imagesToRemove, 'promotion');

        return $updated;
    }
}
