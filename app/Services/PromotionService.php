<?php

namespace App\Services;

use App\Models\Image;
use App\Models\Product;
use App\Models\Promotion;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class PromotionService
{
    public function getAll(): Collection
    {
        return Promotion::with('images')->get();
    }

    public function findById($id)
    {
        return Promotion::with(['images', 'products'])->where('id', $id)->firstOrFail();
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

        // Imagens (mantém sua lógica atual)
        // $this->handleImages($instance, $newImages, $imagesToRemove);

        $this->handleImages($instance, $data['images'], $imagesToRemove, 'promotion');

        return $updated;
    }

    public function store(array $data, array $products): Promotion
    {
        $promotion = Promotion::create($data);

        $attachData = [];
        foreach ($products as $item) {
            $product = Product::find($item['id']);
            if ($product) {
                $attachData[$product->id] = ['quantity' => $item['quantity'] ?? 1];
            }
        }

        if (!empty($attachData)) {
            $promotion->products()->attach($attachData);
        }


        $this->handleImages($promotion, $data['images'], [], 'promotion');

        return $promotion;
    }


    private function handleImages(Model $model, array $newImages = [], array $imagesToRemove = [], $folder = 'default'): void
    {

        if ($model && !empty($newImages)) {
            foreach ($newImages as $image) {
                $path = $image->store($folder, 'public');
                $model->images()->create(['path' => $path]);
            }
        }

        if ($model && !empty($imagesToRemove)) {
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
