<?php

namespace App\Livewire\Forms;

use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class ProductFormValidation extends Form
{
    public ?int $productId = null;
    public $name;
    public $description;
    public $price;

    public function rules()
    {
        return [
            'name' => [
                'required',
                'string',
                'min:3',
                'max:255',
                Rule::unique('products', 'name')->ignore($this->productId),
            ],
            'description' => ['required', 'string', 'min:10'],
            'price' => ['required', 'numeric', 'min:0']
        ];
    }
}
