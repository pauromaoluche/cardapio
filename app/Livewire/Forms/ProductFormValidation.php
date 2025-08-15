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
    public $price = 0;
    public $category_id;

    public $images = [];
    public $existingImageCount = 0;
    public array $imagesToRemove = [];

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
            'price' => ['required', 'numeric', 'min:0.01'],
            'category_id' => ['required', 'exists:categories,id'],

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
