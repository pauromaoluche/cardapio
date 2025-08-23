<?php

namespace App\Services;

use App\Models\Config;
use Illuminate\Support\Facades\DB;
use Throwable;

class ConfigService
{
    public function get()
    {
        return Config::find(1);
    }

    public function update(int $id, array $data): bool
    {
        DB::beginTransaction();

        try {
            $instance = Config::findOrFail($id);

            $updated = $instance->update($data);

            DB::commit();

            return $updated;
        } catch (Throwable $e) {

            DB::rollBack();
            throw $e;
        }
    }
}
