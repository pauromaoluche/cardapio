@props([
    'route' => null
])

<div class="btn-group" role="group">
    <button type="submit" class="btn btn-success">Salvar</button>
    <button type="button" class="btn btn-primary" wire:click="save(true)">Salvar e adicionar
        outro</button>
    <a href="{{ $route }}" type="button" class="btn btn-danger">Voltar</a>
</div>
