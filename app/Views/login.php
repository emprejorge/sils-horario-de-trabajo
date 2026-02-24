<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Sistema de Gestión de Horarios</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Google Font -->
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
            margin: 0;
            height: 100vh;
            background: #0f172a;
        }

        .split-container {
            display: flex;
            height: 100vh;
        }

        /* PANEL IZQUIERDO */
        .left-panel {
            flex: 1;
            background: linear-gradient(135deg, #1e293b, #0f172a);
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 80px;
            position: relative;
            overflow: hidden;
        }

        .left-panel::before {
            content: "";
            position: absolute;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(59,130,246,0.3), transparent 70%);
            top: -150px;
            right: -150px;
        }

        .left-panel h1 {
            font-weight: 700;
            font-size: 2.3rem;
        }

        .left-panel p {
            margin-top: 20px;
            color: rgba(255,255,255,0.8);
            max-width: 420px;
        }

        .illustration {
            margin-top: 40px;
            max-width: 400px;
        }

        /* PANEL DERECHO */
        .right-panel {
            flex: 1;
            background: #f8fafc;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
        }

        .login-card {
            background: white;
            border-radius: 20px;
            padding: 50px 40px;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.08);
            animation: fadeIn 0.8s ease;
        }

        .institution-logo {
            width: 109px;
            height: 146px;
            background: #e2e8f0;
            border-radius: 12px;
            margin: 0 auto 25px auto;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #64748b;
            font-size: 0.8rem;
            text-align: center;
        }

        .google-btn {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 12px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: all 0.2s ease;
        }

        .google-btn:hover {
            background: #f1f5f9;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.08);
        }

        .google-icon {
            width: 20px;
        }

        .footer-text {
            font-size: 0.8rem;
            color: #64748b;
            margin-top: 20px;
            text-align: center;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* RESPONSIVE */
        @media (max-width: 992px) {
            .split-container {
                flex-direction: column;
            }

            .left-panel {
                padding: 50px 30px;
                text-align: center;
                align-items: center;
            }

            .right-panel {
                padding: 30px;
            }
        }
    </style>
</head>
<body>

<div class="split-container">

    <!-- PANEL IZQUIERDO -->
    <div class="left-panel">
        <h1>Sistema de registro de<br/>horas laborales</h1>
        <p>
            Plataforma institucional diseñada para registrar,
            revisar y aprobar horarios laborales de manera eficiente.
            Garantiza control administrativo y validación oficial.
        </p>

        <!-- Ilustración -->
        <div class="illustration text-left">
            <i class="bi bi-calendar2-check"
            style="font-size: 50px; color: #3b82f6;"></i>
        </div>
    </div>

    <!-- PANEL DERECHO -->
    <div class="right-panel">
        <div class="login-card text-center">

            <!-- LOGO PLACEHOLDER 109x146 -->
            <div class="institution-logo">
                <img src="https://www.scuolaitalianalaserena.cl/logos/logo-chico-fondo-blanco.jpg">
                
            </div>

            <h5 class="mb-3 fw-semibold">Acceso Institucional</h5>

            <a href="/auth/google" class="google-btn text-decoration-none">
                <img class="google-icon"
                     src="https://www.svgrepo.com/show/475656/google-color.svg"
                     alt="Google Logo">
                Ingresar con Google
            </a>

            <div class="footer-text">
                Acceso exclusivo para personal de la <br/>Scuola Italiana de La Serena
            </div>

        </div>
    </div>

</div>

</body>
</html>