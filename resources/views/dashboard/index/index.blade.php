@extends('dashboard.layouts.app')
@section('content')
    <!-- Dashboard Content -->
    <main class="p-4">
        <!-- Page Header -->
        <div class="mb-4">
            <h1 class="h3 fw-bold mb-1">Dashboard</h1>
            <p class="text-muted mb-0">Gerencie os pedidos da sua lanchonete</p>
        </div>

        <div class="row g-4 mb-5">
            <livewire:dashboard.components.status-card title="Pedidos Pendentes" icon="bi bi-clock"
                bg="warning-custom text-warning" />
            <livewire:dashboard.components.status-card title="Em Preparo" icon="bi bi-bag" bg="info-custom text-info" />
            <livewire:dashboard.components.status-card title="Prontos" icon="bi bi-check-circle"
                bg="success-custom text-success" />
            <livewire:dashboard.components.status-card title="Faturamento Hoje" icon="bi bi-graph-up"
                bg="primary-custom text-primary-custom" />
        </div>

        <!-- Orders Section -->
        <div class="mb-4">
            <h2 class="h5 fw-semibold mb-4">Pedidos Recentes</h2>
            <livewire:dashboard.components.recent-orders>
        </div>
    </main>
@endsection
