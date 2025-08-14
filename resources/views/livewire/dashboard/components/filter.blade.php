<div class="d-flex gap-2 flex-wrap status-filter">
    <button class="btn filter-btn @if ($filter === 'all') active @endif" wire:click="setFilter('all')">
        <i class="fas fa-list me-1"></i>Todos
    </button>
    @foreach ($statuses as $status)
        <button class="btn filter-btn @if ($filter === $status->name) active @endif"
            wire:click="setFilter('{{ $status->name }}')">
            <i class="{{ $status->icon }} me-1"></i>{{ $status->name }}
        </button>
    @endforeach
</div>
