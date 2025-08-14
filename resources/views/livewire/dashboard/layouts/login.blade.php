<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ 'FoodAdmin - Painel de Administração' }}</title>

    <meta name="description"
        content="Sistema de gerenciamento para lanchonetes - Controle de pedidos, clientes e relatórios">

    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/web/web.css', 'resources/css/web/responsive.css'])
</head>

<body>
    <main>
        {{ $slot }}
    </main>
    </div>
</body>

</html>
