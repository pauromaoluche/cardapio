<?php

namespace App\Livewire\Forms;

use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class DiscountFormValidation extends Form
{
    public ?int $discountId = null;
    public $product_id;
    public $discount_type;
    public $discount_value = 0.0;
    public $start_date = null;
    public $end_date = null;

    public function rules()
    {
        return [
            'product_id' => [
                'required',
                'exists:products,id',
                Rule::unique('discounts', 'product_id')->ignore($this->discountId)
            ],
            'discount_type' => ['required', Rule::in(['fixed', 'percentage'])],
            'discount_value' => ['required', 'numeric', 'min:0.01'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after:start_date']
        ];
    }
}
