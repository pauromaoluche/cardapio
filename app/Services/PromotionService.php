<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Promotion;
use App\Traits\ImageHandling;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

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

    public function getPromotions(string $category): Collection
    {

        $query = Promotion::select(
            'id',
            'title',
            'description',
            'discount_type',
            'discount_value',
            'start_date',
            'end_date',
            'active'
        )->with([
            'images' => function ($query) {
                $query->select('imageable_id', 'path');
            },
            'products' => function ($query) {
                $query->select('products.id', 'products.category_id', 'products.name', 'products.price')->with([
                    'images' => function ($query) {
                        $query->select('imageable_id', 'path');
                    },
                ]);
            },
        ])
            ->where('active', true)
            ->whereDate('start_date', '<=', now())
            ->whereDate('end_date', '>=', now());

        if ($category !== 'all') {
            $query->whereHas('products', function ($q) use ($category) {
                $q->where('category_id', $category);
            });
        }

        return $query->get();
    }

    public function store(array $data): Promotion
    {
        DB::beginTransaction();

        try {
            $instance = Promotion::create($data);

            $attachData = [];
            foreach ($data['selected_products'] as $item) {
                $product = Product::find($item['id']);
                if ($product) {
                    $attachData[$product->id] = ['quantity' => $item['quantity'] ?? 1];
                }
            }

            if (!empty($attachData)) {
                $instance->products()->attach($attachData);
            }

            $this->handleImages($instance, $data['images'], [], 'promotion');

            DB::commit();

            return $instance;
        } catch (Throwable $e) {

            DB::rollBack();

            Log::channel('promotion')->error('Erro ao criar promoção.', [
                'error_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'data' => $data,
            ]);
            throw $e;
        }
    }

    public function update(int $id, array $data, array $imagesToRemove): bool
    {

        DB::beginTransaction();

        try {

            $instance = Promotion::findOrFail($id);

            $updated = $instance->update($data);

            $attachData = [];
            foreach ($data['selected_products'] as $item) {
                $product = Product::find($item['id']);
                if ($product) {
                    $attachData[$product->id] = ['quantity' => $item['quantity'] ?? 1];
                }
            }

            // Atualiza o pivot (remove e adiciona conforme necessário)
            $instance->products()->sync($attachData);

            $this->handleImages($instance, $data['images'], $imagesToRemove, 'promotion');

            DB::commit();

            return $updated;
        } catch (Throwable $e) {
            DB::rollBack();

            Log::channel('promotion')->error("Erro ao atualizar a promoção #{$id}.", [
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
            $instance = Promotion::findOrFail($id);

            $this->deleteModelImages($instance);

            $delete = $instance->delete();

            DB::commit();

            return $delete;
        } catch (Throwable $e) {

            DB::rollBack();

            Log::channel('promotion')->error("Erro ao excluir a promoão #{$id}.", [
                'error_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            throw $e;
        }
    }
}
