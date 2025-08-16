<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'Ps - Cardapio Online' }}</title>

    <meta name="description"
        content="Sistema de gerenciamento para lanchonetes - Controle de pedidos, clientes e relatórios">
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/web/web.css', 'resources/css/web/responsive.css'])
</head>

<body>
    <x-web.hero />
    <main>
        {{ $slot }}
    </main>
    @include('livewire.web.layouts._footer')
    </div>
    @vite(['resources/js/dashboard/app.js'])
    @stack('scripts')
</body>

</html>
