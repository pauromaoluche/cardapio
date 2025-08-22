<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class CheckoutFormValidation extends Form
{
    public $name = '';
    public $whatsapp = '';
    public $address = '';
    public $payment_method = '';
    public $observation = '';
    public $pickup_in_store = false;
    public $change_to = 0;
    public $order_total = 0;

    public function rules()
    {
        $rules = [
            'name' => 'required|string|max:255',
            'whatsapp' => 'required|string|max:20',
            'observation' => 'nullable|string|max:500',
            'pickup_in_store' => 'boolean'
        ];

        if (!$this->pickup_in_store) {
            $rules['address'] = 'required|string|max:255';
            $rules['payment_method'] = 'required|in:credit,debit,cash,pix';
            // Se pagamento for dinheiro, exige troco
            if ($this->payment_method === 'cash') {
                $rules['change_to'] = 'required|numeric|min:0';
            }
        }

        return $rules;
    }
}
