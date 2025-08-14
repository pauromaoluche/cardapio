<div>
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h1 class="h3 mb-1">Lista de Pedidos</h1>
                    <p class="text-muted-foreground mb-0">Gerencie todos os pedidos da lanchonete</p>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-secondary">
                        <i class="fas fa-download me-1"></i>Exportar
                    </button>
                    <button class="btn bg-primary text-primary-foreground">
                        <i class="fas fa-plus me-1"></i>Novo Pedido
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters and Search -->
    <div class="row mb-4">
        <div class="col-lg-8">
            <livewire:dashboard.components.filter />

        </div>
        <div class="col-lg-4 mt-3 mt-sm-3 mt-md-3 mt-lg-0">
            <livewire:dashboard.components.search-filter />
        </div>
    </div>

    <livewire:dashboard.components.recent-orders colClass="col-12">
</div>
