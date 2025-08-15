<?php

namespace App\Services;

use App\Models\Category;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class CategoryService
{
    public function getAll(): Collection
    {
        return Category::all();
    }

    public function findById(int $id): Category
    {
        return Category::find($id);
    }

    public function store(array $data): Category
    {
        DB::beginTransaction();

        try {
            $category = Category::create($data);

            DB::commit();

            return $category;
        } catch (Throwable $e) {

            DB::rollBack();

            Log::channel('category')->error('Erro ao criar a categoria.', [
                'error_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'data' => $data,
            ]);
            throw $e;
        }
    }

    public function update(int $id, array $data): bool
    {
        DB::beginTransaction();

        try {
            $instance = Category::findOrFail($id);

            $updated = $instance->update($data);

            DB::commit();

            return $updated;
        } catch (Throwable $e) {

            DB::rollBack();

            Log::channel('category')->error("Erro ao atualizar a categoria #{$id}.", [
                'error_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'data_received' => $data
            ]);
            throw $e;
        }
    }

    public function destroy(int $id): bool
    {
        DB::beginTransaction();

        try {
            $instance = Category::findOrFail($id);

            if ($instance->products()->exists()) {

                $productNames = $instance->products->pluck('name')->implode(', ');
                throw new Exception("Esta categoria está vinculado aos seguintes produtos e não pode ser excluído: [{$productNames}], remova as categorias desses produtos para poder excluir.");
            }

            $delete = $instance->delete();

            DB::commit();

            return $delete;
        } catch (Exception $e) {

            DB::rollBack();

            Log::channel('category')->error("Erro ao excluir a categoria #{$id}.", [
                'error_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            throw $e;
        }
    }
}
