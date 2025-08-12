@props([
    'route' => null,
])
<div class="btn-group" role="group">
    <a href="{{ $route }}" class="btn btn-success">Editar</a>
    <button type="button" class="btn btn-danger">Remover</button>
</div>
