@props([
    'image',
    'path' => null,
    'key',
    'removeMethod' => 'removeImageTemporary',
    'imagesToRemove' => [],
    'isExistingImage' => false
])

{{-- Adiciona a classe apenas se for uma imagem existente E estiver no array de remoção --}}
<div class="position-relative @if ($isExistingImage && in_array($image->id, $imagesToRemove)) image-remove @endif">
    <img src="{{ $path ?? $image->temporaryUrl() }}" alt="Preview" class="img-thumbnail" style="height: 100px;">

    <button type="button" wire:click="{{ $removeMethod }}({{ $key }})"
        class="btn btn-sm bg-custom position-absolute top-0 end-0"
        style="border-radius: 50%; width: 25px; height: 25px; padding: 0;">
        &times;
    </button>
</div>
