<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Status;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class OrderService
{
    public function getAll(?string $filter = null, ?string $search = null, ?int $limit = null): Collection
    {
        $query = Order::with(['products', 'status', 'promotions'])->latest()->whereDate('created_at', today());

        if ($filter && $filter !== 'all') {
            $status = Status::firstWhere('name', $filter);
            if ($status) {
                $query->where('status_id', $status->id);
            }
        }

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('client_name', 'like', '%' . $search . '%')
                    ->orWhere('client_phone', 'like', '%' . $search . '%')
                    ->orWhere('id', 'like', '%' . $search . '%')
                    ->orWhereHas('products', function (Builder $q) use ($search) {
                        $q->where('name', 'like', '%' . $search . '%');
                    });
            });
        }

        if ($limit !== null) {
            $query->limit($limit);
        }

        return $query->get();
    }
}
