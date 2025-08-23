<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'Ps - Cardapio - Painel de Administração' }}</title>

    <meta name="description"
        content="Sistema de gerenciamento para lanchonetes - Controle de pedidos, clientes e relatórios">

    @vite(['resources/css/app.css', 'resources/css/dashboard/admin.css', 'resources/css/dashboard/responsive.css'])
</head>

<body>
    @include('livewire.dashboard.layouts._sidebar')
    <div class="main-content">
        @include('livewire.dashboard.layouts._header')
        <main>
            {{ $slot }}
        </main>
    </div>
    @vite(['resources/js/dashboard/app.js'])
     @stack('scripts')
</body>

</html>
