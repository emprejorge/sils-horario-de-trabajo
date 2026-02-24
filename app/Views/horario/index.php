<?php $bloqueado = $horario['approved'] ? true : false; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Horarios</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
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
            background: #f1f5f9;
        }

        .navbar-custom {
            background: white;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        }

        .user-card {
            background: linear-gradient(135deg, #1e293b, #0f172a);
            color: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }

        .user-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            border: 3px solid rgba(255,255,255,0.4);
        }

        .card-dashboard {
            border-radius: 20px;
            border: none;
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
        }

        .table-modern th {
            background: #f8fafc;
            font-weight: 600;
        }

        .status-badge {
            padding: 6px 12px;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .status-aprobado {
            background: #dcfce7;
            color: #166534;
        }

        .status-pendiente {
            background: #fef9c3;
            color: #854d0e;
        }
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-light navbar-custom px-4">
    <span class="navbar-brand fw-bold">
        <i class="bi bi-calendar2-week-fill text-primary"></i>
        Sistema de Horas de Trabajo
    </span>

    <div class="ms-auto d-flex align-items-center gap-3">
        <span class="fw-semibold"><?= session()->get('user')['name'] ?></span>
        <img src="<?= base_url(session()->get('user')['avatar']) ?>" class="rounded-circle" width="40">
        <a href="/logout" class="btn btn-outline-danger btn-sm">
            <i class="bi bi-box-arrow-right"></i> Salir
        </a>
    </div>
</nav>

<div class="container mt-5">
    <div class="row g-4">
<!-- HORARIO -->


<?php $bloqueado = $horario['approved'] ? true : false; ?>

<div class="col-lg-12">
<div class="card card-dashboard p-4">

<h5 class="fw-bold mb-4">
    <i class="bi bi-clock-history text-primary"></i>
    Mi horario de trabajo
</h5>

 <?php if ($horario['approved']): ?>
                    <span class="badge bg-success fs-6">
                        <i class="bi bi-check-circle"></i>
                        Aprobado por Convivencia Escolar  el <?= date('d/m/Y H:i', strtotime($horario['approved_at'])) ?>
                    </span>
                <?php else: ?>
                    <span class="badge bg-warning text-dark fs-6">
                        <i class="bi bi-clock-history"></i>
                        Pendiente de aprobación
                    </span>
                <?php endif; ?>

                <br>
<form method="post" action="/horario/save">

<?php
$dias = [
    'lun' => 'Lunes',
    'mar' => 'Martes',
    'mie' => 'Miércoles',
    'jue' => 'Jueves',
    'vie' => 'Viernes'
];
?>

<div class="table-responsive">
<table class="table table-bordered text-center align-middle">

<thead class="table-dark">
<tr>
    <th></th>
    <?php foreach($dias as $key => $dia): ?>
        <th>
            <div class="d-flex flex-column align-items-center">
                <span><?= $dia ?></span>

                <?php if (!$bloqueado): ?>
                    <button type="button"
                        class="btn btn-sm btn-outline-light mt-1 copiar-siguiente"
                        data-from="<?= $key ?>"
                        title="Copiar día completo al siguiente">
                        <i class="bi bi-arrow-right"></i>
                    </button>
                <?php endif; ?>
            </div>
        </th>
    <?php endforeach; ?>
</tr>
</thead>

<tbody>

<!-- Entrada Mañana -->
<tr>
<td class="fw-bold bg-light">
    <i class="bi bi-sunrise"></i> Entrada Mañana
    <?php if (!$bloqueado): ?>
        <button type="button" class="btn btn-sm btn-outline-primary ms-2 copiar-columna" data-tipo="entrada_manana" title="Copiar entrada mañana del lunes a toda la semana">
            <i class="bi bi-files"></i>
        </button>
    <?php endif; ?>
</td>
<?php foreach($dias as $key => $dia): ?>
<td>
<input type="time"
    class="form-control horario-input"
    name="<?= $key ?>_entrada_manana"
    value="<?= $horario[$key.'_entrada_manana'] ?>"
    <?= $bloqueado ? 'disabled' : '' ?>>
</td>
<?php endforeach; ?>
</tr>

<!-- Salida Mañana -->
<tr>
<td class="fw-bold bg-light">
    <i class="bi bi-sun"></i> Salida Mañana
    <?php if (!$bloqueado): ?>
        <button type="button" class="btn btn-sm btn-outline-primary ms-2 copiar-columna" data-tipo="salida_manana" title="Copiar salida mañana del lunes a toda la semana">
            <i class="bi bi-files"></i>
        </button>
    <?php endif; ?>
</td>
<?php foreach($dias as $key => $dia): ?>
<td>
<input type="time"
    class="form-control horario-input"
    name="<?= $key ?>_salida_manana"
    value="<?= $horario[$key.'_salida_manana'] ?>"
    <?= $bloqueado ? 'disabled' : '' ?>>
</td>
<?php endforeach; ?>
</tr>

<tr class="table-secondary">
<td class="fw-bold">Total Mañana</td>
<?php foreach($dias as $key => $dia): ?>
<td id="<?= $key ?>_total_manana">0</td>
<?php endforeach; ?>
</tr>

<!-- Entrada Tarde -->
<tr>
<td class="fw-bold bg-light">
    <i class="bi bi-brightness-high"></i> Entrada Tarde
    <?php if (!$bloqueado): ?>
        <button type="button" class="btn btn-sm btn-outline-primary ms-2 copiar-columna" data-tipo="entrada_tarde" title="Copiar entrada tarde del lunes a toda la semana">
            <i class="bi bi-files"></i>
        </button>
    <?php endif; ?>
</td>
<?php foreach($dias as $key => $dia): ?>
<td>
<input type="time"
    class="form-control horario-input"
    name="<?= $key ?>_entrada_tarde"
    value="<?= $horario[$key.'_entrada_tarde'] ?>"
    <?= $bloqueado ? 'disabled' : '' ?>>
</td>
<?php endforeach; ?>
</tr>

<!-- Salida Tarde -->
<tr>
<td class="fw-bold bg-light">
    <i class="bi bi-sunset"></i> Salida Tarde
    <?php if (!$bloqueado): ?>
        <button type="button" class="btn btn-sm btn-outline-primary ms-2 copiar-columna" data-tipo="salida_tarde" title="Copiar salida tarde del lunes a toda la semana">
            <i class="bi bi-files"></i>
        </button>
    <?php endif; ?>
</td>
<?php foreach($dias as $key => $dia): ?>
<td>
<input type="time"
    class="form-control horario-input"
    name="<?= $key ?>_salida_tarde"
    value="<?= $horario[$key.'_salida_tarde'] ?>"
    <?= $bloqueado ? 'disabled' : '' ?>>
</td>
<?php endforeach; ?>
</tr>

<tr class="table-secondary">
<td class="fw-bold">Total Tarde</td>
<?php foreach($dias as $key => $dia): ?>
<td id="<?= $key ?>_total_tarde">0</td>
<?php endforeach; ?>
</tr>

<tr class="table-primary">
<td class="fw-bold">Total Día</td>
<?php foreach($dias as $key => $dia): ?>
<td id="<?= $key ?>_total_dia">0</td>
<?php endforeach; ?>
</tr>

</tbody>
</table>
</div>

<div class="text-end mt-3">
<h5>
    <i class="bi bi-clock-history"></i>
    Total Semanal:
    <span id="total_semanal" class="badge bg-primary fs-6">0</span>
    horas
</h5>
</div>

<div class="text-end mt-3">
<?php if (!$bloqueado): ?>
<button type="submit" class="btn btn-success">
    <i class="bi bi-save"></i> Guardar
</button>
<?php endif; ?>
</div>

</form>
</div>
</div>

<script>

const diasOrden = ['lun','mar','mie','jue','vie'];

/* =========================
   CALCULO ORIGINAL (NO TOCADO)
========================= */

function calcularMinutos(inicio, fin) {
    if (!inicio || !fin) return 0;

    let [h1, m1] = inicio.split(":");
    let [h2, m2] = fin.split(":");

    let minutosInicio = parseInt(h1)*60 + parseInt(m1);
    let minutosFin = parseInt(h2)*60 + parseInt(m2);

    return minutosFin - minutosInicio;
}

function formatearHoras(minutosTotales) {
    if (minutosTotales <= 0) return "0:00";

    let horas = Math.floor(minutosTotales / 60);
    let minutos = minutosTotales % 60;

    return horas + ":" + minutos.toString().padStart(2, '0');
}

function recalcular() {

    let totalSemanal = 0;

    diasOrden.forEach(dia => {

        let em = document.querySelector(`[name="${dia}_entrada_manana"]`).value;
        let sm = document.querySelector(`[name="${dia}_salida_manana"]`).value;
        let et = document.querySelector(`[name="${dia}_entrada_tarde"]`).value;
        let st = document.querySelector(`[name="${dia}_salida_tarde"]`).value;

        let minutosManana = calcularMinutos(em, sm);
        let minutosTarde  = calcularMinutos(et, st);
        let minutosDia    = minutosManana + minutosTarde;

        document.getElementById(`${dia}_total_manana`).innerText = formatearHoras(minutosManana);
        document.getElementById(`${dia}_total_tarde`).innerText  = formatearHoras(minutosTarde);
        document.getElementById(`${dia}_total_dia`).innerText    = formatearHoras(minutosDia);

        totalSemanal += minutosDia;
    });

    document.getElementById("total_semanal").innerText = formatearHoras(totalSemanal);
}

document.querySelectorAll("input[type='time']")
    .forEach(input => input.addEventListener("change", recalcular));

window.onload = recalcular;

/* =========================
   COPIAR DIA COMPLETO AL SIGUIENTE
========================= */

document.querySelectorAll('.copiar-siguiente').forEach(btn => {

    btn.addEventListener('click', function() {

        const fromDia = this.dataset.from;
        const index = diasOrden.indexOf(fromDia);

        if (index === -1 || index === diasOrden.length - 1) return;

        const toDia = diasOrden[index + 1];

        ['entrada_manana','salida_manana','entrada_tarde','salida_tarde']
        .forEach(tipo => {
            let from = document.querySelector(`[name="${fromDia}_${tipo}"]`);
            let to   = document.querySelector(`[name="${toDia}_${tipo}"]`);
            if (from && to) to.value = from.value;
        });

        recalcular();
    });

});

/* =========================
   COPIAR SOLO UNA COLUMNA DESDE LUNES
========================= */

document.querySelectorAll('.copiar-columna').forEach(btn => {

    btn.addEventListener('click', function() {

        const tipo = this.dataset.tipo;

        diasOrden.forEach(dia => {

            if (dia === 'lun') return;

            let from = document.querySelector(`[name="lun_${tipo}"]`);
            let to   = document.querySelector(`[name="${dia}_${tipo}"]`);

            if (from && to) to.value = from.value;
        });

        recalcular();
    });

});

</script>


        <script>
document.addEventListener('DOMContentLoaded', function () {

    const tiposOrden = [
        'entrada_manana',
        'salida_manana',
        'entrada_tarde',
        'salida_tarde'
    ];

    const inputs = Array.from(document.querySelectorAll('.horario-input'));

    // Si no hay inputs editables, salir
    const editables = inputs.filter(i => !i.disabled);
    if (editables.length === 0) return;

    inputs.forEach(input => {

        input.addEventListener('keydown', function(e) {

            if (e.key !== 'Tab') return;

            const partes = this.name.split('_');
            const diaActual = partes[0];
            const tipoActual = partes.slice(1).join('_');

            const indexDia = diasOrden.indexOf(diaActual);
            const indexTipo = tiposOrden.indexOf(tipoActual);

            let siguiente = null;

            // =========================
            // TAB NORMAL (↓)
            // =========================
            if (!e.shiftKey) {

                // Bajar dentro del mismo día
                if (indexTipo < tiposOrden.length - 1) {

                    const siguienteTipo = tiposOrden[indexTipo + 1];

                    siguiente = document.querySelector(
                        `[name="${diaActual}_${siguienteTipo}"]:not([disabled])`
                    );

                } else {

                    // Última fila → siguiente día
                    if (indexDia < diasOrden.length - 1) {

                        const siguienteDia = diasOrden[indexDia + 1];

                        siguiente = document.querySelector(
                            `[name="${siguienteDia}_entrada_manana"]:not([disabled])`
                        );
                    }
                }
            }

            // =========================
            // SHIFT + TAB (↑)
            // =========================
            else {

                // Subir dentro del mismo día
                if (indexTipo > 0) {

                    const anteriorTipo = tiposOrden[indexTipo - 1];

                    siguiente = document.querySelector(
                        `[name="${diaActual}_${anteriorTipo}"]:not([disabled])`
                    );

                } else {

                    // Primera fila → ir al día anterior
                    if (indexDia > 0) {

                        const diaAnterior = diasOrden[indexDia - 1];

                        siguiente = document.querySelector(
                            `[name="${diaAnterior}_salida_tarde"]:not([disabled])`
                        );
                    }
                }
            }

            // Si existe siguiente, cancelar comportamiento normal
            if (siguiente) {
                e.preventDefault();
                siguiente.focus();
            }

        });

    });

});
</script>


<!-- .HORARIO -->
    </div>
</div>
<!-- Bootstrap JS (necesario para Toast, Tooltip, Modal, etc) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<?= $this->include('components/toast') ?>
</body>
</html>