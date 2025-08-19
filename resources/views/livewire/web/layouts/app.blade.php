<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'Ps - Cardapio Online' }}</title>

    <meta name="description"
        content="Sistema de gerenciamento para lanchonetes - Controle de pedidos, clientes e relatórios">
    @vite(['resources/css/app.css', 'resources/css/web/web.css', 'resources/css/web/responsive.css'])
</head>

<body>
    <x-web.hero />
    <main>
        {{ $slot }}
    </main>
    <livewire:web.components.cart-off-canvas />
    <livewire:web.components.modal-product />
    <livewire:web.components.cart />
    @include('livewire.web.layouts._footer')
    @vite('resources/js/web/app.js')
</body>

</html>
