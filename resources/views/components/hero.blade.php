@props([
    'title' => null,
    'description' => null,
    'route' => null,
])


<div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
    <div>
        <h1 class="h3 mb-1">{{ $title }}</h1>
        <p class="text-muted-foreground mb-0">{{ $description }}</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ $route }}" wire:navigate class="btn btn-success">Adicionar</a>
    </div>
</div>
