<?php

namespace App\Livewire\Web\Components;

use App\Services\AuxService;
use App\Services\ProductService;
use App\Services\PromotionService;
use Livewire\Component;

class CartOffCanvas extends Component
{
    public $cartItems = [];
    public $totalPrice = 0;
    public $totalPriceWithDeliveryFee = 0;

    protected $listeners = [
        'off-canvas' => 'openOffCanvas'
    ];

    protected ProductService $productService;
    protected PromotionService $promotionService;
    protected AuxService $auxService;

    public function boot(ProductService $productService, PromotionService $promotionService, AuxService $auxService)
    {
        $this->productService = $productService;
        $this->promotionService = $promotionService;
        $this->auxService = $auxService;
    }

    public function decreaseQuantity($itemIndex)
    {

        if (isset($this->cartItems[$itemIndex]) && $this->cartItems[$itemIndex]['quantity'] > 1) {
            $this->cartItems[$itemIndex]['quantity']--;
            $this->cartItems[$itemIndex]['total_price'] = $this->cartItems[$itemIndex]['final_price'] * $this->cartItems[$itemIndex]['quantity'];
            $this->updateSession();
        }
    }

    public function increaseQuantity($itemIndex)
    {
        if (isset($this->cartItems[$itemIndex])) {
            $this->cartItems[$itemIndex]['quantity']++;
            $this->cartItems[$itemIndex]['total_price'] = $this->cartItems[$itemIndex]['final_price'] * $this->cartItems[$itemIndex]['quantity'];
            $this->updateSession();
        }
    }

    public function removeItem($itemIndex)
    {
        if (isset($this->cartItems[$itemIndex])) {
            unset($this->cartItems[$itemIndex]);
            $this->cartItems = array_values($this->cartItems);
            $this->updateSession();

            if (count($this->cartItems) === 0) {
                $this->dispatch('close-offcanvas');
                $this->dispatch('desactive-cart');
            }
        }
    }

    public function checkout()
    {
        $this->dispatch('close-offcanvas');

        return redirect()->route('checkout');
    }

    private function updateSession()
    {
        session()->put('cart', $this->cartItems);

        $this->calculateTotalPrice();
    }

    public function openOffCanvas()
    {
        $cartItemsFromSession = session()->get('cart', []);

        $validatedCartItems = [];

        foreach ($cartItemsFromSession as $item) {
            if ($item['type'] === 'promotion') {
                $dbItem = $this->promotionService->findByIdCheckout($item['id']);
            } else {
                $dbItem = $this->productService->findByIdCheckout($item['id']);
            }

            if ($dbItem) {
                $dbItemData = $dbItem->toArray();
                $dbItemData['type'] = $item['type'];

                $calculatedItem = $this->auxService->calculateTotalPrice($dbItemData, $item['quantity']);

                $validatedCartItems[] = [
                    'id' => $item['id'],
                    'type' => $item['type'],
                    'image' => $item['image'],
                    'name' => $item['type'] == 'promotion' ? $dbItemData['title'] : $dbItemData['name'],
                    'price' => $item['type'] == 'promotion' ? $calculatedItem['price'] : $dbItemData['price'],
                    'final_price' => $calculatedItem['final_price'],
                    'total_price' => $calculatedItem['total_price'],
                    'quantity' => $item['quantity'],
                    'observation' => $item['observation'] ?? ''
                ];
            } else {
                session()->flash('error', 'Ocorreu um ao abrir os pedidos, se persistir, faça o pedido pelo WhatsApp.');
                return redirect()->route('index');
            }
        }
        $this->cartItems = $validatedCartItems;

        $this->updateSession();

        $this->dispatch('open-offcanvas');
    }

    private function calculateTotalPrice()
    {
        $this->totalPrice = 0;
        foreach ($this->cartItems as $item) {
            $this->totalPrice += $item['final_price'] * $item['quantity'];
        }

        $this->totalPriceWithDeliveryFee = $this->totalPrice + config_get('delivery_fee');
    }

    public function render()
    {
        return view('livewire.web.components.cart-off-canvas');
    }
}
