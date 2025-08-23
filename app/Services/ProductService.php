<?php

namespace App\Services;

use App\Models\Product;
use App\Traits\ImageHandling;
use Exception;
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
        return Product::with(['images', 'discount'])->where('id', $id)->firstOrFail();
    }

    public function findByIdCheckout(int $id): Product
    {
        return Product::with(['discount' => function ($query) {
            $query->select('product_id', 'discount_type', 'discount_value', 'start_date', 'end_date');
        },])->where('id', $id)->firstOrFail();
    }

    public function findByCategory(string $category): Collection
    {
        $query = Product::select('id', 'category_id', 'name', 'description', 'price')->with([
            'images' => function ($query) {
                $query->select('imageable_id', 'path');
            },
            'discount' => function ($query) {
                $query->select('product_id', 'discount_type', 'discount_value', 'start_date', 'end_date')
                    ->where('start_date', '<=', now())
                    ->where('end_date', '>=', now());
            },
        ]);

        if ($category !== 'all') {

            $query->where('category_id', $category);
        }
        return $query->get();
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

            Log::channel('product')->error('Erro ao criar produto.', [
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

            Log::channel('product')->error("Erro ao atualizar a produto #{$id}.", [
                'error_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'data_received' => $data,
                'images_removed' => $imagesToRemove,
            ]);
            throw $e;
        }
    }

    public function destroy(int $id): bool
    {
        DB::beginTransaction();

        try {
            $instance = Product::findOrFail($id);

            if ($instance->promotions()->exists()) {

                $promotionNames = $instance->promotions->pluck('title')->implode(', ');
                throw new Exception("Este produto está vinculado às seguintes promoções e não pode ser excluído: [{$promotionNames}], remova ele das promoções para poder excluir.");
            }

            $this->deleteModelImages($instance);

            $delete = $instance->delete();

            DB::commit();

            return $delete;
        } catch (Exception $e) {

            DB::rollBack();

            Log::channel('product')->error("Erro ao excluir a produto #{$id}.", [
                'error_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            throw $e;
        }
    }

    public function search(?string $search = null): Collection
    {
        $query = product::with('images');

        if (!empty($search)) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        return $query->get();
    }
}
