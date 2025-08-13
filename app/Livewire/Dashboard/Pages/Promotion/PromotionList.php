<?php

namespace App\Livewire\Dashboard\Pages\Promotion;

use App\Services\PromotionService;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;

class PromotionList extends Component
{
    public $promotions;
    protected PromotionService $promotionService;

    public function boot(PromotionService $promotionService)
    {
        $this->promotionService = $promotionService;
    }

    public function mount()
    {
        $this->promotions = $this->promotionService->getAll();
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
            $this->promotionService->destroy($id);

            $this->reloadData();
            $this->dispatch('swal:message', ['icon' => 'success', 'title' => 'Sucesso!', 'text' => 'Item deletado com sucesso.']);
        } catch (\Throwable $e) {
            $this->dispatch('swal:message', ['icon' => 'error', 'title' => 'Erro!', 'text' => 'Ocorreu um erro ao excluir a promoção, se persistir, contate o administrador.']);
        }
    }

    public function reloadData()
    {
        $this->promotions = $this->promotionService->getAll();
    }

    #[Title('Promocoes')]
    public function render()
    {
        return view('livewire.dashboard.pages.promotion.promotion-list')->layout('livewire.dashboard.layouts.app');
    }
}
