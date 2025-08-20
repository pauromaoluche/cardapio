<?php

namespace App\Livewire\Web\Pages\Checkout;

use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class CheckoutForm extends Component
{
    public $name = '';
    public $whatsapp = '';
    public $address = '';
    public $paymentMethod = 'credit';

    // Propriedades para os dados do carrinho
    public $cartItems = [];
    public $totalPrice = 0;

    // Propriedade para controlar a exibição da mensagem de sucesso
    public $orderFinalized = false;

    public function mount()
    {
        $this->cartItems = session()->get('cart', []);
        $this->calculateTotalPrice();
    }

    private function calculateTotalPrice()
    {
        $this->totalPrice = 0;
        foreach ($this->cartItems as $item) {
            $this->totalPrice += $item['price'] * $item['quantity'];
        }
    }

    public function finalizeOrder()
    {
        // dd($this->cartItems);
        // 1. Validação dos dados do formulário
        $this->validate([
            'name' => 'required|string|max:255',
            'whatsapp' => 'nullable|string|max:20',
            'address' => 'required|string|max:255',
        ]);

        // 2. Transação de banco de dados para garantir que tudo seja salvo ou nada seja salvo
        DB::transaction(function () {
            // 3. Cria o novo pedido na tabela 'orders'
            $order = Order::create([
                'client_name' => $this->name,
                'client_phone' => $this->whatsapp,
                'address' => $this->address,
                'total_value' => $this->totalPrice,
                'delivery_fee' => 0.00,
                'payment_type' => $this->paymentMethod,
                'change_to' => 0.00,
                'status_id' => 1,
            ]);

            // 4. Anexa os itens (produtos e promoções) ao pedido nas tabelas pivot
            foreach ($this->cartItems as $item) {
                $quantity = $item['quantity'];

                // Verifica se o item é um produto ou uma promoção
                if (isset($item['type']) && $item['type'] === 'promotion') {
                    // Anexa a promoção à ordem
                    $order->promotions()->attach($item['id'], [
                        'quantity' => $quantity,
                        'observation' => 'teste1'
                    ]);
                } else {
                    // Anexa o produto à ordem com os dados da tabela pivot
                    $order->products()->attach($item['id'], [
                        'quantity' => $quantity,
                        'observation' => 'teste2' // Adiciona uma observação opcional se precisar
                    ]);
                }
            }

        });

        // 5. Limpa o carrinho da sessão após o pedido ser finalizado
        session()->forget('cart');
        $this->cartItems = [];
        $this->calculateTotalPrice();

        // 6. Exibe a mensagem de sucesso
        $this->orderFinalized = true;

        // Opcionalmente, emite um evento para o componente do carrinho se ele estiver visível
        // $this->dispatch('refresh-cart');
    }

    public function render()
    {
        return view('livewire.web.pages.checkout.checkout-form')->layout('livewire.web.layouts.app');
    }
}
