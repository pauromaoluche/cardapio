<?php

namespace App\Services;

use App\Models\Discount;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class DiscountService
{
    public function getAll(): Collection
    {
        return Discount::with('product')->get();
    }

    public function findById(int $id): Discount
    {
        return Discount::with('product')->where('id', $id)->firstOrFail();
    }

    public function store(array $data): Discount
    {
        DB::beginTransaction();

        try {
            $discount = Discount::create($data);

            DB::commit();

            return $discount;
        } catch (Throwable $e) {

            DB::rollBack();

            Log::channel('discount')->error('Erro ao criar desconto.', [
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
            $instance = Discount::findOrFail($id);

            $updated = $instance->update($data);

            DB::commit();

            return $updated;
        } catch (Throwable $e) {

            DB::rollBack();

            Log::channel('discount')->error("Erro ao atualizar o desconto #{$id}.", [
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
            $instance = Discount::findOrFail($id);

            $delete = $instance->delete();

            DB::commit();

            return $delete;
        } catch (Exception $e) {

            DB::rollBack();

            Log::channel('discount')->error("Erro ao excluir o desconto #{$id}.", [
                'error_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            throw $e;
        }
    }
}
