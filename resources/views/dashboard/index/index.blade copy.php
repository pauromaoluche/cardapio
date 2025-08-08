<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FoodAdmin - Painel de Administração</title>
    <meta name="description"
        content="Sistema de gerenciamento para lanchonetes - Controle de pedidos, clientes e relatórios">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

    <style>
        :root {
            /* Cores do tema lanchonete */
            --primary-color: #ff6b35;
            --primary-glow: #ff8c42;
            --success-color: #22c55e;
            --warning-color: #fbbf24;
            --info-color: #3b82f6;
            --danger-color: #ef4444;

            /* Cores neutras */
            --bg-color: #fafafa;
            --card-bg: #ffffff;
            --text-primary: #1f2937;
            --text-secondary: #6b7280;
            --border-color: #e5e7eb;

            /* Sombras */
            --shadow-card: 0 4px 12px -2px rgba(255, 107, 53, 0.1);
            --shadow-hover: 0 8px 24px -4px rgba(255, 107, 53, 0.15);

            /* Bordas */
            --border-radius: 12px;
        }

        body {
            background-color: var(--bg-color);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: var(--text-primary);
        }

        /* Sidebar */
        .sidebar {
            background: var(--card-bg);
            border-right: 1px solid var(--border-color);
            box-shadow: 2px 0 8px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid var(--border-color);
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .brand-icon {
            width: 32px;
            height: 32px;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-glow));
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: var(--shadow-card);
        }

        .sidebar-nav {
            padding: 1rem;
        }

        .nav-item {
            margin-bottom: 0.5rem;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            border-radius: var(--border-radius);
            color: var(--text-primary);
            text-decoration: none;
            transition: all 0.2s ease;
            font-weight: 500;
        }

        .nav-link:hover {
            background-color: rgba(255, 107, 53, 0.1);
            color: var(--primary-color);
        }

        .nav-link.active {
            background: var(--primary-color);
            color: white;
            box-shadow: var(--shadow-card);
        }

        /* Header */
        .main-header {
            background: var(--card-bg);
            border-bottom: 1px solid var(--border-color);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .search-box {
            position: relative;
            width: 250px;
        }

        .search-box input {
            padding-left: 2.5rem;
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
        }

        .search-icon {
            position: absolute;
            left: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-secondary);
        }

        /* Cards */
        .card {
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-card);
            transition: all 0.3s ease;
            background: var(--card-bg);
        }

        .card:hover {
            box-shadow: var(--shadow-hover);
        }

        .stat-card .card-body {
            padding: 1.5rem;
        }

        .stat-icon {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }

        .stat-value {
            font-size: 2rem;
            font-weight: bold;
            margin: 0;
        }

        .stat-label {
            color: var(--text-secondary);
            font-size: 0.875rem;
            margin: 0;
        }

        /* Order Cards */
        .order-card {
            background: linear-gradient(145deg, #ffffff, #f9fafb);
        }

        .order-number {
            width: 40px;
            height: 40px;
            background: rgba(255, 107, 53, 0.1);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: var(--primary-color);
            font-size: 0.875rem;
        }

        /* Status Badges */
        .status-badge {
            padding: 0.5rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
        }

        .status-pending {
            background: var(--warning-color);
            color: var(--text-primary);
        }

        .status-preparing {
            background: var(--info-color);
            color: white;
        }

        .status-ready {
            background: var(--success-color);
            color: white;
        }

        .status-delivered {
            background: var(--text-secondary);
            color: white;
        }

        /* Utilities */
        .text-primary-custom {
            color: var(--primary-color) !important;
        }

        .bg-warning-custom {
            background-color: rgba(251, 191, 36, 0.2) !important;
        }

        .bg-info-custom {
            background-color: rgba(59, 130, 246, 0.2) !important;
        }

        .bg-success-custom {
            background-color: rgba(34, 197, 94, 0.2) !important;
        }

        .bg-primary-custom {
            background-color: rgba(255, 107, 53, 0.2) !important;
        }

        .avatar {
            width: 32px;
            height: 32px;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-glow));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 0.875rem;
        }

        .notification-dot {
            position: absolute;
            top: -2px;
            right: -2px;
            width: 8px;
            height: 8px;
            background: var(--primary-color);
            border-radius: 50%;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                position: fixed;
                left: -250px;
                top: 0;
                height: 100vh;
                z-index: 1000;
                width: 250px;
            }

            .sidebar.show {
                left: 0;
            }

            .search-box {
                width: 200px;
            }
        }

        .sidebar-toggle {
            background: none;
            border: none;
            color: var(--text-secondary);
            font-size: 1.2rem;
            cursor: pointer;
        }

        .sidebar-toggle:hover {
            color: var(--primary-color);
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar position-fixed start-0 top-0 h-100" id="sidebar" style="width: 250px; z-index: 1000;">
        <div class="sidebar-header">
            <div class="sidebar-brand">
                <div class="brand-icon">
                    <i class="bi bi-shop text-white"></i>
                </div>
                <div>
                    <h5 class="mb-0 fw-bold">FoodAdmin</h5>
                    <small class="text-muted">Painel de controle</small>
                </div>
            </div>
        </div>

        <div class="sidebar-nav">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link active" href="#dashboard">
                        <i class="bi bi-house"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#pedidos">
                        <i class="bi bi-bag"></i>
                        <span>Pedidos</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#clientes">
                        <i class="bi bi-people"></i>
                        <span>Clientes</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#relatorios">
                        <i class="bi bi-graph-up"></i>
                        <span>Relatórios</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#configuracoes">
                        <i class="bi bi-gear"></i>
                        <span>Configurações</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content" style="margin-left: 250px;">
        <!-- Header -->
        <header class="main-header py-3 px-4">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-3">
                    <button class="sidebar-toggle d-md-none" onclick="toggleSidebar()">
                        <i class="bi bi-list"></i>
                    </button>

                    <div class="search-box">
                        <i class="bi bi-search search-icon"></i>
                        <input type="text" class="form-control" placeholder="Buscar pedidos, clientes...">
                    </div>
                </div>

                <div class="d-flex align-items-center gap-3">
                    <button class="btn btn-link position-relative p-2" style="color: var(--text-secondary);">
                        <i class="bi bi-bell"></i>
                        <span class="notification-dot"></span>
                    </button>

                    <div class="avatar">A</div>
                </div>
            </div>
        </header>

        <!-- Dashboard Content -->
        <main class="p-4">
            <!-- Page Header -->
            <div class="mb-4">
                <h1 class="h3 fw-bold mb-1">Dashboard</h1>
                <p class="text-muted mb-0">Gerencie os pedidos da sua lanchonete</p>
            </div>

            <!-- Statistics Cards -->
            <div class="row g-4 mb-5">
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="card stat-card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <p class="stat-label">Pedidos Pendentes</p>
                                    <p class="stat-value">1</p>
                                </div>
                                <div class="stat-icon bg-warning-custom text-warning">
                                    <i class="bi bi-clock"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="card stat-card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <p class="stat-label">Em Preparo</p>
                                    <p class="stat-value">1</p>
                                </div>
                                <div class="stat-icon bg-info-custom text-info">
                                    <i class="bi bi-bag"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="card stat-card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <p class="stat-label">Prontos</p>
                                    <p class="stat-value">1</p>
                                </div>
                                <div class="stat-icon bg-success-custom text-success">
                                    <i class="bi bi-check-circle"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="card stat-card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <p class="stat-label">Faturamento Hoje</p>
                                    <p class="stat-value text-primary-custom">R$ 146,70</p>
                                </div>
                                <div class="stat-icon bg-primary-custom text-primary-custom">
                                    <i class="bi bi-graph-up"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Orders Section -->
            <div class="mb-4">
                <h2 class="h5 fw-semibold mb-4">Pedidos Recentes</h2>

                <div class="row g-4">
                    <!-- Order Card 1 -->
                    <div class="col-12 col-lg-6 col-xl-4">
                        <div class="card order-card">
                            <div class="card-header bg-transparent border-0 pb-2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="order-number">#1001</div>
                                        <div>
                                            <h6 class="mb-0 fw-semibold">Pedido #1001</h6>
                                            <small class="text-muted d-flex align-items-center gap-1">
                                                <i class="bi bi-clock"></i>
                                                09:45
                                            </small>
                                        </div>
                                    </div>
                                    <span class="status-badge status-preparing">
                                        <i class="bi bi-tools"></i>
                                        Preparando
                                    </span>
                                </div>
                            </div>

                            <div class="card-body pt-0">
                                <!-- Cliente -->
                                <div class="d-flex gap-2 mb-3">
                                    <i class="bi bi-person text-muted mt-1"></i>
                                    <div class="flex-grow-1">
                                        <p class="mb-0 fw-medium small">Maria Silva</p>
                                        <p class="mb-0 text-muted" style="font-size: 0.75rem;">(11) 99999-9999</p>
                                        <div class="d-flex gap-1 mt-1">
                                            <i class="bi bi-geo-alt text-muted" style="font-size: 0.75rem;"></i>
                                            <p class="mb-0 text-muted" style="font-size: 0.75rem;">Rua das Flores, 123
                                                -
                                                Vila Madalena</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Itens -->
                                <div class="mb-3">
                                    <h6 class="text-muted mb-2"
                                        style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">
                                        Itens</h6>
                                    <div class="small">
                                        <div class="d-flex justify-content-between mb-1">
                                            <div>
                                                <span class="fw-medium">2x X-Bacon</span>
                                                <div class="text-muted"
                                                    style="font-size: 0.75rem; font-style: italic;">
                                                    Obs: Sem cebola</div>
                                            </div>
                                            <span class="fw-medium">R$ 37,80</span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-1">
                                            <span class="fw-medium">1x Batata Frita</span>
                                            <span class="fw-medium">R$ 12,00</span>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <span class="fw-medium">2x Coca-Cola</span>
                                            <span class="fw-medium">R$ 11,00</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Total -->
                                <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                                    <div class="d-flex align-items-center gap-1">
                                        <i class="bi bi-currency-dollar text-primary-custom"></i>
                                        <span class="fw-bold fs-5 text-primary-custom">R$ 60,80</span>
                                    </div>
                                    <small class="text-muted d-flex align-items-center gap-1">
                                        <i class="bi bi-clock"></i>
                                        ~25 min
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Card 2 -->
                    <div class="col-12 col-lg-6 col-xl-4">
                        <div class="card order-card">
                            <div class="card-header bg-transparent border-0 pb-2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="order-number">#1002</div>
                                        <div>
                                            <h6 class="mb-0 fw-semibold">Pedido #1002</h6>
                                            <small class="text-muted d-flex align-items-center gap-1">
                                                <i class="bi bi-clock"></i>
                                                09:30
                                            </small>
                                        </div>
                                    </div>
                                    <span class="status-badge status-ready">
                                        <i class="bi bi-check-circle"></i>
                                        Pronto
                                    </span>
                                </div>
                            </div>

                            <div class="card-body pt-0">
                                <!-- Cliente -->
                                <div class="d-flex gap-2 mb-3">
                                    <i class="bi bi-person text-muted mt-1"></i>
                                    <div class="flex-grow-1">
                                        <p class="mb-0 fw-medium small">João Santos</p>
                                        <p class="mb-0 text-muted" style="font-size: 0.75rem;">(11) 88888-8888</p>
                                        <div class="d-flex gap-1 mt-1">
                                            <i class="bi bi-geo-alt text-muted" style="font-size: 0.75rem;"></i>
                                            <p class="mb-0 text-muted" style="font-size: 0.75rem;">Av. Paulista, 456 -
                                                Bela Vista</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Itens -->
                                <div class="mb-3">
                                    <h6 class="text-muted mb-2"
                                        style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">
                                        Itens</h6>
                                    <div class="small">
                                        <div class="d-flex justify-content-between mb-1">
                                            <span class="fw-medium">1x Pizza Margherita</span>
                                            <span class="fw-medium">R$ 35,00</span>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <span class="fw-medium">1x Guaraná</span>
                                            <span class="fw-medium">R$ 4,50</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Total -->
                                <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                                    <div class="d-flex align-items-center gap-1">
                                        <i class="bi bi-currency-dollar text-primary-custom"></i>
                                        <span class="fw-bold fs-5 text-primary-custom">R$ 39,50</span>
                                    </div>
                                    <small class="text-muted d-flex align-items-center gap-1">
                                        <i class="bi bi-clock"></i>
                                        ~5 min
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Card 3 -->
                    <div class="col-12 col-lg-6 col-xl-4">
                        <div class="card order-card">
                            <div class="card-header bg-transparent border-0 pb-2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="order-number">#1003</div>
                                        <div>
                                            <h6 class="mb-0 fw-semibold">Pedido #1003</h6>
                                            <small class="text-muted d-flex align-items-center gap-1">
                                                <i class="bi bi-clock"></i>
                                                09:55
                                            </small>
                                        </div>
                                    </div>
                                    <span class="status-badge status-pending">
                                        <i class="bi bi-clock"></i>
                                        Pendente
                                    </span>
                                </div>
                            </div>

                            <div class="card-body pt-0">
                                <!-- Cliente -->
                                <div class="d-flex gap-2 mb-3">
                                    <i class="bi bi-person text-muted mt-1"></i>
                                    <div class="flex-grow-1">
                                        <p class="mb-0 fw-medium small">Ana Costa</p>
                                        <p class="mb-0 text-muted" style="font-size: 0.75rem;">(11) 77777-7777</p>
                                    </div>
                                </div>

                                <!-- Itens -->
                                <div class="mb-3">
                                    <h6 class="text-muted mb-2"
                                        style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">
                                        Itens</h6>
                                    <div class="small">
                                        <div class="d-flex justify-content-between mb-1">
                                            <span class="fw-medium">1x Hambúrguer Clássico</span>
                                            <span class="fw-medium">R$ 16,50</span>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <span class="fw-medium">1x Milkshake</span>
                                            <span class="fw-medium">R$ 8,00</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Total -->
                                <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                                    <div class="d-flex align-items-center gap-1">
                                        <i class="bi bi-currency-dollar text-primary-custom"></i>
                                        <span class="fw-bold fs-5 text-primary-custom">R$ 24,50</span>
                                    </div>
                                    <small class="text-muted d-flex align-items-center gap-1">
                                        <i class="bi bi-clock"></i>
                                        ~30 min
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Card 4 -->
                    <div class="col-12 col-lg-6 col-xl-4">
                        <div class="card order-card">
                            <div class="card-header bg-transparent border-0 pb-2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="order-number">#1000</div>
                                        <div>
                                            <h6 class="mb-0 fw-semibold">Pedido #1000</h6>
                                            <small class="text-muted d-flex align-items-center gap-1">
                                                <i class="bi bi-clock"></i>
                                                09:00
                                            </small>
                                        </div>
                                    </div>
                                    <span class="status-badge status-delivered">
                                        <i class="bi bi-truck"></i>
                                        Entregue
                                    </span>
                                </div>
                            </div>

                            <div class="card-body pt-0">
                                <!-- Cliente -->
                                <div class="d-flex gap-2 mb-3">
                                    <i class="bi bi-person text-muted mt-1"></i>
                                    <div class="flex-grow-1">
                                        <p class="mb-0 fw-medium small">Carlos Oliveira</p>
                                        <p class="mb-0 text-muted" style="font-size: 0.75rem;">(11) 66666-6666</p>
                                        <div class="d-flex gap-1 mt-1">
                                            <i class="bi bi-geo-alt text-muted" style="font-size: 0.75rem;"></i>
                                            <p class="mb-0 text-muted" style="font-size: 0.75rem;">Rua Augusta, 789 -
                                                Consolação</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Itens -->
                                <div class="mb-3">
                                    <h6 class="text-muted mb-2"
                                        style="font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">
                                        Itens</h6>
                                    <div class="small">
                                        <div class="d-flex justify-content-between mb-1">
                                            <span class="fw-medium">1x X-Salada</span>
                                            <span class="fw-medium">R$ 15,90</span>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <span class="fw-medium">1x Suco Natural</span>
                                            <span class="fw-medium">R$ 6,00</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Total -->
                                <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                                    <div class="d-flex align-items-center gap-1">
                                        <i class="bi bi-currency-dollar text-primary-custom"></i>
                                        <span class="fw-bold fs-5 text-primary-custom">R$ 21,90</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Overlay for mobile sidebar -->
    <div class="sidebar-overlay d-md-none" id="sidebarOverlay" onclick="toggleSidebar()"></div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Toggle sidebar for mobile
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            const mainContent = document.querySelector('.main-content');

            if (window.innerWidth <= 768) {
                sidebar.classList.toggle('show');

                if (sidebar.classList.contains('show')) {
                    overlay.style.display = 'block';
                    overlay.style.position = 'fixed';
                    overlay.style.top = '0';
                    overlay.style.left = '0';
                    overlay.style.width = '100%';
                    overlay.style.height = '100%';
                    overlay.style.backgroundColor = 'rgba(0,0,0,0.5)';
                    overlay.style.zIndex = '999';
                } else {
                    overlay.style.display = 'none';
                }
            }
        }

        // Handle responsive layout
        function handleResize() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            const mainContent = document.querySelector('.main-content');

            if (window.innerWidth > 768) {
                sidebar.classList.remove('show');
                overlay.style.display = 'none';
                mainContent.style.marginLeft = '250px';
            } else {
                mainContent.style.marginLeft = '0';
            }
        }

        // Navigation
        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', function(e) {
                // Remove active class from all links
                document.querySelectorAll('.nav-link').forEach(l => l.classList.remove('active'));
                // Add active class to clicked link
                this.classList.add('active');
            });
        });

        // Initialize
        window.addEventListener('resize', handleResize);
        handleResize(); // Call on page load
    </script>
</body>

</html>
