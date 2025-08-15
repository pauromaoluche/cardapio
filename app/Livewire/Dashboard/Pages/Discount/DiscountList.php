<?php

namespace App\Livewire\Dashboard\Pages\Discount;

use App\Services\DiscountService;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;

class DiscountList extends Component
{
    public $discounts;
    protected DiscountService $discountService;

    public function boot(DiscountService $discountService)
    {
        $this->discountService = $discountService;
    }

    public function mount()
    {
        $this->discounts = $this->discountService->getAll();
    }

    public function confirmDelete($id)
    {
        $this->dispatch('swal:confirm', [
            'title' => 'Tem certeza?',
            'text' => 'Você realmente quer excluir este item? Isso não poderá ser revertido!',
            'icon' => 'warning',
            'onConfirmedEvent' => 'performDelete',
            'onConfirmedParams' => ['id' => $id]
        ]);
    }

    #[On('performDelete')]
    public function performDelete(array $params): void
    {
        $id = $params['id'] ?? null;
        if (!$id) {
            $this->dispatch('swal:message', ['icon' => 'error', 'title' => 'Erro!', 'text' => 'ID do item não fornecido para exclusão.']);
            return;
        }

        try {
            $this->discountService->destroy($id);

            $this->reloadData();
            $this->dispatch('swal:message', ['icon' => 'success', 'title' => 'Sucesso!', 'text' => 'Item deletado com sucesso.']);
        } catch (\Throwable $e) {
            $this->dispatch('swal:message', ['icon' => 'error', 'title' => 'Erro!', 'text' => 'Ocorreu um erro ao excluir o desconto, se persistir, contate o administrador.']);
        }
    }

    public function reloadData()
    {
        $this->discounts = $this->discountService->getAll();
    }

    #[Title('Descontos')]
    public function render()
    {
        return view('livewire.dashboard.pages.discount.discount-list')->layout('livewire.dashboard.layouts.app');
    }
}
