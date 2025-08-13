<?php

namespace App\Livewire\Forms;

use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Livewire\WithFileUploads;

class PromotionFormValidation extends Form
{
    public ?int $promotionId = null;
    public $title;
    public $description;
    public $discount_type;
    public $discount_value = 0.0;
    public $start_date = null;
    public $end_date = null;
    public $active = true;

    public $images = [];
    public $existingImageCount = 0;
    public array $imagesToRemove = [];
    public $selected_products = [];

    public function rules()
    {
        return [
            'title' => [
                'required',
                'string',
                'min:5',
                Rule::unique('promotions', 'title')->ignore($this->promotionId),
            ],
            'description' => ['required', 'string', 'min:10'],
            'discount_type' => ['required', Rule::in(['fixed', 'percentage'])],
            'discount_value' => ['required', 'numeric', 'min:0.01'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after:start_date'],
            'active' => ['boolean'],
            'selected_products' => ['required', 'array', 'min:1'],

            'images' => [
                'nullable',
                'array',
                function ($attribute, $value, $fail) {
                    $newImageCount = is_array($value) ? count($value) : 0;
                    $totalImagesAfterUpdate = $this->existingImageCount + $newImageCount;

                    if ($totalImagesAfterUpdate > 4) {
                        $fail('O número total de imagens (existentes + novas) não pode ser superior a 4.');
                    }
                    if ($totalImagesAfterUpdate < 1) {
                        $fail('O produto deve ter pelo menos uma imagem.');
                    }
                },
            ],
            'images.*' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ];
    }

    public function messages()
    {
        return [
            'images.*.image' => 'O arquivo selecionado deve ser uma imagem.',
            'images.*.mimes' => 'A imagem deve ser dos tipos: jpeg, png, jpg ou gif.',
            'images.*.max' => 'Cada imagem não pode ter mais que 2MB.',
        ];
    }
}
