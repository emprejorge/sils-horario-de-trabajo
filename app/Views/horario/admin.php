<?= $this->extend('admin/template') ?>

<?= $this->section('content') ?>
<?php $bloqueado = $horario['approved'] ? true : false; ?>

<div class="col-lg-12">
<div class="card card-dashboard p-4">

<h5 class="fw-bold mb-4">
    <i class="bi bi-clock-history text-primary"></i>
    Mi horario de trabajo
</h5>

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

<?php $this->endSection() ?>