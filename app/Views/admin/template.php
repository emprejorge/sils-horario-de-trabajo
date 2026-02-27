<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Panel Administrador</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Favicon -->
    <link rel="icon" href="https://scuolaitalianalaserena.cl/wp-content/uploads/2024/09/cropped-favicon-32x32.jpg" sizes="32x32" />
    <link rel="icon" href="https://scuolaitalianalaserena.cl/wp-content/uploads/2024/09/cropped-favicon-192x192.jpg" sizes="192x192" />
    <link rel="apple-touch-icon" href="https://scuolaitalianalaserena.cl/wp-content/uploads/2024/09/cropped-favicon-180x180.jpg" />
    <meta name="msapplication-TileImage" content="https://scuolaitalianalaserena.cl/wp-content/uploads/2024/09/cropped-favicon-270x270.jpg" />

    <!-- Open Graph básico -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="SILS - Sistema de registro de horas laborales">
    <meta property="og:description" content="Plataforma institucional diseñada para registrar, revisar y aprobar horarios laborales de manera eficiente. Garantiza control administrativo y validación oficial.">
    <meta property="og:url" content="https://horas.scuolaitalianalaserena.cl/index.php/login">
    <meta property="og:image" content="https://scuolaitalianalaserena.cl/logos/scuola-whatsapp.jpg">

    <!-- Opcional pero recomendado -->
    <meta property="og:site_name" content="SILS - Sistema de registro de horas laborales">

    <!-- Twitter (WhatsApp a veces lo usa como fallback) -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="SILS - Sistema de registro de horas laborales">
    <meta name="twitter:description" content="Plataforma institucional diseñada para registrar, revisar y aprobar horarios laborales de manera eficiente. Garantiza control administrativo y validación oficial.">
    <meta name="twitter:image" content="https://scuolaitalianalaserena.cl/logos/scuola-whatsapp.jpg">




    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f1f5f9;
            overflow-x: hidden;
        }

        /* SIDEBAR */
        .sidebar {
            height: 100vh;
            background: linear-gradient(180deg, #0f172a, #1e293b);
            color: white;
            position: fixed;
            width: 250px;
            padding-top: 20px;
            transition: all 0.3s ease;
        }

        .sidebar .brand {
            font-weight: 700;
            font-size: 1.2rem;
            padding: 0 20px;
            margin-bottom: 30px;
        }

        .sidebar a {
            display: block;
            color: rgba(255, 255, 255, 0.8);
            padding: 12px 20px;
            text-decoration: none;
            transition: all 0.2s ease;
            border-left: 3px solid transparent;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background: rgba(255, 255, 255, 0.05);
            color: white;
            border-left: 3px solid #3b82f6;
        }

        /* MAIN CONTENT */
        .main-content {
            margin-left: 250px;
            padding: 20px;
        }

        /* NAVBAR */
        .top-navbar {
            background: white;
            padding: 15px 25px;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
            margin-bottom: 25px;
        }

        /* CARD */
        .card-dashboard {
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
        }

        /* TABLE */
        .table-modern th {
            background-color: #f8fafc;
            font-weight: 600;
        }

        /* RESPONSIVE */
        @media (max-width: 992px) {
            .sidebar {
                width: 200px;
            }

            .main-content {
                margin-left: 200px;
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                position: relative;
                width: 100%;
                height: auto;
            }

            .main-content {
                margin-left: 0;
            }
        }
    </style>

    <?= $this->renderSection('styles') ?>
</head>

<body>

    <!-- SIDEBAR -->
    <div class="sidebar">
        <div class="brand">
            <i class="bi bi-calendar2-check text-primary"></i>
            SILS: Horas
        </div>

        <a href="<?= base_url('admin') ?>" class="<?= url_is('admin') ? 'active' : '' ?>">
            <i class="bi bi-speedometer2 me-2"></i> Dashboard
        </a>

        <a href="<?= base_url('horario') ?>" class="<?= url_is('horario') ? 'active' : '' ?>">
            <i class="bi bi-calendar2-week me-2"></i> Mi horario
        </a>

        <a href="<?= base_url('admin/usuarios') ?>" class="<?= url_is('admin/usuarios')  ? 'active' : '' ?> <?= url_is('admin/horario/*')  ? 'active' : '' ?>">
            <i class="bi bi-people me-2"></i> Usuarios
        </a>



    </div>

    <!-- MAIN -->
    <div class="main-content">

        <!-- NAVBAR SUPERIOR -->
        <div class="top-navbar d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-semibold">
                Panel de Administración
            </h5>

            <div class="d-flex align-items-center gap-3">
                <span class="fw-semibold"><?= session()->get('user')['name'] ?></span>

                <img src="<?= base_url(session()->get('user')['avatar']) ?>" alt="Avatar"
                    class="rounded-circle"
                    width="40">

                <a href="/logout" class="btn btn-outline-danger btn-sm rounded-pill">
                    <i class="bi bi-box-arrow-right"></i> Salir
                </a>
            </div>
        </div>

        <!-- CONTENIDO DINÁMICO -->
        <div class="card card-dashboard p-4">
            <?= $this->renderSection('content') ?>
        </div>

    </div>

    <!-- Bootstrap JS (necesario para Toast, Tooltip, Modal, etc) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <?= $this->renderSection('scripts') ?>

    <?= $this->include('components/toast') ?>
</body>

</html>