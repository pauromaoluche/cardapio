@props([
    'route' => null,
    'id' => null,
])
<div class="btn-group" role="group">
    <a href="{{ route($route, ['id' => $id]) }}" class="btn btn-success">Editar</a>
    <button wire:click="confirmDelete({{ $id }})" type="button" class="btn btn-danger">Remover</button>
</div>
