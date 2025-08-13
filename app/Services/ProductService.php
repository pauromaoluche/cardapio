<?php

namespace App\Services;

use App\Models\Product;
use App\Traits\ImageHandling;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

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
        DB::beginTransaction();

        try {
            $product = Product::create($data);

            $this->handleImages($product, $data['images'], [], 'product');

            DB::commit();

            return $product;
        } catch (Throwable $e) {

            DB::rollBack();

            Log::channel('promotion')->error('Erro ao criar produto.', [
                'error_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'data' => $data,
            ]);
            throw $e;
        }
    }

    public function update(int $id, array $data, array $imagesToRemove = []): bool
    {
        DB::beginTransaction();

        try {
            $instance = Product::findOrFail($id);

            $updated = $instance->update($data);

            $this->handleImages($instance, $data['images'], $imagesToRemove, 'product');

            DB::commit();

            return $updated;
        } catch (Throwable $e) {

            DB::rollBack();

            Log::channel('promotion')->error("Erro ao atualizar a produto #{$id}.", [
                'error_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'data_received' => $data,
                'images_removed' => $imagesToRemove,
            ]);
            throw $e;
        }
    }
}
