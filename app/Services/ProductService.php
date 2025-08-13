<?php

namespace App\Services;

use App\Models\Product;
use App\Traits\ImageHandling;
use Illuminate\Database\Eloquent\Collection;

class ProductService
{

    use ImageHandling;

    public function getAll(): Collection
    {
        return Product::with('images')->get();
    }

    public function findById(int $id): Product
    {
        return Product::with('images')->where('id', $id)->firstOrFail();
    }

    public function store(array $data): Product
    {
        $product = Product::create($data);

        $this->handleImages($product, $data['images'], [], 'product');

        return $product;
    }

    public function update(int $id, array $data, array $imagesToRemove = []): bool
    {
        $instance = Product::findOrFail($id);

        $updated = $instance->update($data);

        $this->handleImages($instance, $data['images'], $imagesToRemove, 'product');

        return $updated;
    }
}
