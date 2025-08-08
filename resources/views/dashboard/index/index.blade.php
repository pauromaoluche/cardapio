@extends('dashboard.layouts.app')
@section('content')
    <!-- Dashboard Content -->
    <main class="p-4">
        <!-- Page Header -->
        <div class="mb-4">
            <h1 class="h3 fw-bold mb-1">Dashboard</h1>
            <p class="text-muted mb-0">Gerencie os pedidos da sua lanchonete</p>
        </div>

        <livewire:dashboard.components.status-cards />

        <!-- Orders Section -->
        <div class="mb-4">
            <h2 class="h5 fw-semibold mb-4">Pedidos Recentes</h2>
            <livewire:dashboard.components.recent-orders>
        </div>
    </main>
@endsection
