<?= $this->extend('admin/template') ?>

<?= $this->section('content') ?>
<?php $bloqueado = $horario['approved'] ? true : false; ?>
        <!-- TABLA HORARIOS -->
        <div class="col-lg-12">
            <div class="card card-dashboard p-4">
                <h5 class="fw-bold mb-4">
                    <i class="bi bi-clock-history text-primary"></i>
                    Mi horario de trabajo
                </h5>

                <form method="post" action="/horario/save">

                <div class="table-responsive">
                    <table class="table table-bordered text-center align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th></th>
                                <th>Lunes</th>
                                <th>Martes</th>
                                <th>Miércoles</th>
                                <th>Jueves</th>
                                <th>Viernes</th>
                            </tr>
                        </thead>
                        <tbody>

<?php
$dias = [
    'lun' => 'Lunes',
    'mar' => 'Martes',
    'mie' => 'Miércoles',
    'jue' => 'Jueves',
    'vie' => 'Viernes'
];
?>

<!-- Entrada Mañana -->
<tr>
    <td class="fw-bold bg-light">
        <i class="bi bi-sunrise"></i> Entrada Mañana
    </td>
    <?php foreach($dias as $key => $dia): ?>
        <td>
            <input type="time"
                class="form-control horario-input"
                data-dia="<?= $key ?>"
                data-row="1"
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
    </td>
    <?php foreach($dias as $key => $dia): ?>
        <td>
            
            <input type="time"
                    class="form-control horario-input"
                    data-dia="<?= $key ?>"
                    data-row="2"
                    name="<?= $key ?>_salida_manana"
                    value="<?= $horario[$key.'_salida_manana'] ?>"
                    <?= $bloqueado ? 'disabled' : '' ?>>
        </td>
    <?php endforeach; ?>
</tr>

<!-- Total Mañana -->
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
    </td>
    <?php foreach($dias as $key => $dia): ?>
        <td>
            <input type="time"
                    class="form-control horario-input"
                    data-dia="<?= $key ?>"
                    data-row="3"
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
    </td>
    <?php foreach($dias as $key => $dia): ?>
        <td>
            <input type="time"
                    class="form-control horario-input"
                    data-dia="<?= $key ?>"
                    data-row="4"
                    name="<?= $key ?>_salida_tarde"
                    value="<?= $horario[$key.'_salida_tarde'] ?>"
                    <?= $bloqueado ? 'disabled' : '' ?>>
        </td>
    <?php endforeach; ?>
</tr>

<!-- Total Tarde -->
<tr class="table-secondary">
    <td class="fw-bold">Total Tarde</td>
    <?php foreach($dias as $key => $dia): ?>
        <td id="<?= $key ?>_total_tarde">0</td>
    <?php endforeach; ?>
</tr>

<!-- Total Día -->
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

    let dias = ['lun','mar','mie','jue','vie'];
    let totalSemanal = 0;

    dias.forEach(dia => {

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

</script>



<script>

document.querySelectorAll('.horario-input').forEach(input => {

    input.addEventListener('keydown', function(e) {

        if (e.key === 'Tab' && !e.shiftKey) {
            e.preventDefault();

            let diaActual = this.dataset.dia;
            let rowActual = parseInt(this.dataset.row);

            let dias = ['lun','mar','mie','jue','vie'];
            let indexDia = dias.indexOf(diaActual);

            let siguiente;

            // Si no es la última fila (4)
            if (rowActual < 4) {
                siguiente = document.querySelector(
                    `.horario-input[data-dia="${diaActual}"][data-row="${rowActual + 1}"]`
                );
            } 
            else {
                // Si es última fila → ir a siguiente día
                if (indexDia < dias.length - 1) {
                    let siguienteDia = dias[indexDia + 1];

                    siguiente = document.querySelector(
                        `.horario-input[data-dia="${siguienteDia}"][data-row="1"]`
                    );
                }
            }

            if (siguiente) {
                siguiente.focus();
            }
        }

    });

});

</script>
<?php $this->endSection() ?>