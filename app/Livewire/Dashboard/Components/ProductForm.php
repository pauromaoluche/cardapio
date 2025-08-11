<?php

namespace App\Livewire\Dashboard\Components;

use App\Models\Image;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class ProductForm extends Component
{
    use WithFileUploads;

    public $name;
    public $description;
    public $price;
    public $images = [];
    public $successMessage;
    public $product;
    public array $imagesToRemove = [];

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255|unique:products,name,' . ($this->product->id ?? 'null'),
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'images' => [
                'nullable',
                'array',
                function ($attribute, $value, $fail) {
                    $existingImageCount = ($this->product?->images->count() ?? 0) - count($this->imagesToRemove);
                    // $existingImageCount = $this->product?->images->count() ?? 0;

                    $newImageCount = is_array($value) ? count($value) : 0;

                    $totalImagesAfterUpdate = $existingImageCount + $newImageCount;

                    if ($totalImagesAfterUpdate > 4) {
                        $fail('O número total de imagens (existentes + novas) não pode ser superior a 4.');
                    }
                    if ($totalImagesAfterUpdate < 1) {
                        $fail('O produto deve ter pelo menos uma imagem.');
                    }
                },
            ],
        ];
    }

    protected $messages = [
        'images.max' => 'Você pode carregar no máximo 4 arquivos.',
        'images.*.image' => 'O arquivo deve ser uma imagem.',
        'images.*.mimes' => 'A imagem deve ser dos tipos: jpeg, png, jpg, gif.',
        'images.*.max' => 'Cada imagem não pode ter mais que 2MB.',
    ];

    public function mount($productId = null)
    {
        if ($productId) {
            $this->product = Product::with('images')->findOrFail($productId);
            $this->name = $this->product->name;
            $this->description = $this->product->description;
            $this->price = $this->product->price;
        }
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function removeImageTemporary($index)
    {
        if (isset($this->images[$index])) {
            unset($this->images[$index]);
            $this->images = array_values($this->images);
            // $this->resetErrorBag('images');
            $this->validateOnly('images');
        }
    }

    public function toggleImageRemoval(int $imageId): void
    {
        if (($key = array_search($imageId, $this->imagesToRemove)) !== false) {
            unset($this->imagesToRemove[$key]);
        } else {
            $this->imagesToRemove[] = $imageId;
        }
        $this->validateOnly('images');
    }

    public function save(bool $addOther = false)
    {
        $this->validate();

        if ($this->product) {
            $this->product->update([
                'name' => $this->name,
                'description' => $this->description,
                'price' => $this->price,
            ]);
            $product = $this->product;
        } else {
            $product = Product::create([
                'name' => $this->name,
                'description' => $this->description,
                'price' => $this->price,
            ]);
        }

        if ($product && !empty($this->images)) {
            foreach ($this->images as $image) {
                $path = $image->store('products', 'public');
                $product->images()->create(['path' => $path]);
            }
        }
        if (!empty($this->imagesToRemove)) {
            $instances = Image::whereIn('id', $this->imagesToRemove)->get();


            foreach ($instances as $instance) {

                if (Storage::disk('public')->exists($instance->path)) {
                    Storage::disk('public')->delete($instance->path);
                }

                $instance->delete();
            }
        }


        if ($addOther) {
            session()->flash('success', 'Produto ' . ($this->product ? 'atualizado' : 'criado') . ' com sucesso! Adicione outro.');
            return redirect()->route('dashboard.product.create');
        }
        session()->flash('success', $this->product ? 'Produto atualizado com sucesso!' : 'Produto criado com sucesso!');
        return redirect()->route('dashboard.product');
    }

    public function render()
    {
        return view('livewire.dashboard.components.product-form');
    }
}
