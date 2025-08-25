<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Status;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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

    /**
     * Cria um novo pedido a partir dos dados do cliente e dos itens do carrinho.
     *
     * @param array $orderInfo  Dados do formulário de checkout.
     * @param array $cartItems  Itens validados do carrinho.
     * @return Order
     * @throws Exception Se o carrinho estiver vazio ou a transação falhar.
     */
    public function orderCreate(array $orderInfo, array $cartItems): Order
    {
        if (empty($cartItems)) {
            throw new Exception("Não é possível criar um pedido com o carrinho vazio.");
        }

        try {
            DB::beginTransaction();
            $order = Order::create([
                'client_name' => $orderInfo['name'],
                'client_phone' => $orderInfo['whatsapp'],
                'address' => $orderInfo['address'],
                'observation' => $orderInfo['observation'],
                'pickup_in_store' => $orderInfo['pickup_in_store'],
                'total_value' => $orderInfo['total_value'],
                'delivery_fee' => $orderInfo['delivery_fee'],
                'payment_type' => $orderInfo['payment_method'],
                'change_to' => $orderInfo['change_to'],
                'status_id' => 1,
            ]);

            foreach ($cartItems as $item) {
                $quantity = $item['quantity'];

                if (isset($item['type']) && $item['type'] === 'promotion') {
                    $order->promotions()->attach($item['id'], [
                        'quantity' => $quantity,
                        'observation' => $item['observation'],
                        'unit_price' => $item['final_price']
                    ]);
                } else {
                    $order->products()->attach($item['id'], [
                        'quantity' => $quantity,
                        'observation' => $item['observation'],
                        'unit_price' => $item['final_price']
                    ]);
                }
            }

            DB::commit();

            return $order;
        } catch (Exception $e) {
            DB::rollBack();
            Log::channel('checkout')->error("Erro ao criar pedido.", [
                'error_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'order_info' => $orderInfo,
                'cart_items' => $cartItems,
            ]);
            throw new Exception("Ocorreu um erro ao finaliar o pedido, caso aconteça novamente, faça o pedido pelo WhatsApp.");
        }
    }

    public function getCountsByStatus(array $statusIds): \Illuminate\Support\Collection
    {
        return Order::select('status_id', DB::raw('count(*) as count'))
            ->where('created_at', today())
            ->whereIn('status_id', $statusIds)
            ->groupBy('status_id')
            ->get()
            ->keyBy('status_id');
    }

    public function getTodayRevenue(): float
    {
        return Order::whereDate('created_at', today())
            ->where('status_id', 4)
            ->sum('total_value');
    }
}
