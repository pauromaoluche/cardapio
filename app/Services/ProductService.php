<?php

namespace App\Services;

use App\Models\Image;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;

class ProductService
{
    public function getAll(): Collection
    {
        return Product::with('images')->get();
    }

    public function findById(int $id): Product
    {
        return Product::with('images')->where('id', $id)->firstOrFail();
    }

    public function store(array $data, array $images): Product
    {
        $product = Product::create($data);

        $this->handleImages($product, $images);

        return $product;
    }

    public function update(int $id, array $data, array $newImages = [], array $imagesToRemove = []): bool
    {
        $instance = Product::findOrFail($id);

        $product = $instance->update($data);

        $this->handleImages($instance, $newImages, $imagesToRemove);

        return $product;
    }

    private function handleImages(Product $product, array $newImages = [], array $imagesToRemove = []): void
    {

        if ($product && !empty($newImages)) {
            foreach ($newImages as $image) {
                $path = $image->store('products', 'public');
                $product->images()->create(['path' => $path]);
            }
        }

        if ($product && !empty($imagesToRemove)) {
            $instances = Image::whereIn('id', $imagesToRemove)->get();

            foreach ($instances as $instance) {
                if (Storage::disk('public')->exists($instance->path)) {
                    Storage::disk('public')->delete($instance->path);
                }
                $instance->delete();
            }
        }
    }
}
