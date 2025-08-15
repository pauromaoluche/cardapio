<?php

namespace App\Livewire\Forms;

use Illuminate\Validation\Rule;
use Livewire\Form;

class CategoryFormValidation extends Form
{
    public ?int $categoryId = null;
    public $name;

    public function rules()
    {
        return [
            'name' => [
                'required',
                'string',
                'min:3',
                'max:255',
                Rule::unique('categories', 'name')->ignore($this->categoryId),
            ],
        ];
    }
}
