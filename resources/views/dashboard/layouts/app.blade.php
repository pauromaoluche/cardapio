<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>FoodAdmin - Painel de Administração</title>
    <meta name="description"
        content="Sistema de gerenciamento para lanchonetes - Controle de pedidos, clientes e relatórios">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/css/admin.css', 'resources/js/app.js'])

</head>

<body>
    <header>
    </header>
    @include('dashboard.layouts._sidebar')
    <div class="main-content" style="margin-left: 250px;">
        @include('dashboard.layouts._header')
        <main>
            @yield('content')
        </main>
    </div>
</body>

</html>
