<?php

namespace App\Livewire\Web\Pages\Checkout;

use App\Livewire\Forms\CheckoutFormValidation;
use App\Services\AuxService;
use App\Services\OrderService;
use App\Services\ProductService;
use App\Services\PromotionService;
use Exception;
use Livewire\Attributes\Locked;
use Livewire\Component;

class CheckoutForm extends Component
{
    public CheckoutFormValidation $form;

    public $cartList = [];
    public $quantity = 0;

    #[Locked]
    public $cartItems = [];
    public $totalPrice = 0;

    public $orderFinalized = false;

    protected AuxService $auxService;
    protected ProductService $productService;
    protected OrderService $orderService;
    protected PromotionService $promotionService;

    public function boot(AuxService $auxService, ProductService $productService, PromotionService $promotionService, OrderService $orderService)
    {
        $this->productService = $productService;
        $this->promotionService = $promotionService;
        $this->auxService = $auxService;
        $this->orderService = $orderService;
    }

    public function mount()
    {
        $this->form = new CheckoutFormValidation($this, 'form');

        $this->cartItems = session()->get('cart', []);

        $this->validateAndCalculatePrices();
    }

    /**
     * Valida os itens do carrinho e calcula os preços totais.
     *
     * Atualiza:
     * - $this->cartItems com os itens validados e calculados.
     * - $this->totalPrice com o valor total do carrinho.
     * - $this->cartList com os dados para exibição no frontend.
     * - $this->quantity com a quantidade total de itens.
     *
     * @return void
     */
    private function validateAndCalculatePrices()
    {
        $this->totalPrice = 0;
        $validatedCartItems = [];

        foreach ($this->cartItems as $item) {
            if ($item['type'] === 'promotion') {
                $dbItem = $this->promotionService->findByIdCheckout($item['id']);
            } else {
                $dbItem = $this->productService->findByIdCheckout($item['id']);
            }

            if ($dbItem) {
                $dbItemData = $dbItem->toArray();

                $dbItemData['type'] = $item['type'];
                $dbItemData['quantity'] = $item['quantity'];

                $calculatedItem = $this->auxService->calculateTotalPrice($dbItemData, $item['quantity']);

                $this->totalPrice += $calculatedItem['total_price'];
                $calculatedItem['observation'] = $item['observation'] ?? '';
                $validatedCartItems[] = $calculatedItem;
                $this->quantity += $dbItemData['quantity'];

                $this->cartList[] = [
                    'name' =>  $item['type'] == 'promotion' ? $dbItemData['title'] : $dbItemData['name'],
                    'quantity' => $dbItemData['quantity'],
                    'total_price' => $calculatedItem['total_price'],
                ];
            } else {
                session()->flash('error', 'Ocorreu um erro ao finalizar o pedido, se persistir, faça o pedido pelo WhatsApp.');
                return redirect()->route('index');
            }
        }
        $this->cartItems = $validatedCartItems;
    }

    /**
     * Finaliza o pedido:
     * - Valida o formulário
     * - Cria o pedido usando OrderService
     * - Limpa a sessão do carrinho
     * - Atualiza estado do componente para indicar que o pedido foi finalizado
     *
     * @throws Exception Caso ocorra algum erro na criação do pedido.
     */
    public function finalizeOrder()
    {
        $this->form->validate();

        try {
            $orderInfo = $this->form->all();
            $orderInfo['total_value'] = $this->totalPrice;

            $this->orderService->orderCreate($orderInfo, $this->cartItems);

            session()->forget('cart');
            $this->cartItems = [];
            $this->validateAndCalculatePrices();
            $this->orderFinalized = true;
        } catch (Exception $e) {
            session()->flash('error', $e->getMessage());
            return redirect()->route('index');
        }
    }

    public function render()
    {
        return view('livewire.web.pages.checkout.checkout-form')->layout('livewire.web.layouts.app');
    }
}
