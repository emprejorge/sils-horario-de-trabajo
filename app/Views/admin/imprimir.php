<?php

$dias = [
    'lun' => 'Lunes',
    'mar' => 'Martes',
    'mie' => 'Miércoles',
    'jue' => 'Jueves',
    'vie' => 'Viernes'
];

function calcularMinutos($inicio, $fin)
{
    if (!$inicio || !$fin) return 0;

    [$h1, $m1] = explode(':', $inicio);
    [$h2, $m2] = explode(':', $fin);

    $inicioMin = $h1 * 60 + $m1;
    $finMin = $h2 * 60 + $m2;

    return $finMin - $inicioMin;
}

function formatearHoras($min)
{
    if ($min <= 0) return "0:00";

    $h = floor($min / 60);
    $m = $min % 60;

    return $h . ":" . str_pad($m, 2, '0', STR_PAD_LEFT);
}

$totalSemanal = 0;

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">
    <title>Horario Laboral</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        @page {
            size: Letter;
            margin: 2cm;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 14px;
            color: #000;
        }

        .header {
            text-align: center;
            margin-bottom: 25px;
        }

        .info {
            margin-bottom: 20px;
        }

        .table th,
        .table td {
            text-align: center;
        }

        .table {
            font-size: 13px;
        }

        .firmas {
            margin-top: 80px;
        }

        .firma-linea {
            border-top: 1px solid #000;
            width: 260px;
            margin: auto;
            margin-top: 60px;
        }

        .table-wrapper {
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid #dee2e6;
        }

        .table thead {
            background: #2e6f87;
            color: white;
        }

        .table-secondary {
            background: #e9ecef !important;
        }

        .table-primary {
            background: #d6ecf3 !important;
            font-weight: bold;
        }

        /* asegurar que los colores se impriman */

        @media print {

            body {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

        }
    </style>

</head>

<body>

    <div class="container-fluid">

        <!-- ENCABEZADO -->

        <div class="header">

            <h3><strong>SCUOLA ITALIANA LA SERENA</strong></h3>
            <p>Sistema de Registro de Horas Laborales</p>

            <h5 class="mt-3">Horario de Trabajo</h5>

        </div>


        <!-- INFO FUNCIONARIO -->

        <div class="row info">

            <div class="col-6">

                <strong>Funcionario:</strong><br>
                <?= $usuario['first_name'] ?> <?= $usuario['last_name'] ?>

            </div>

            <div class="col-3">

                <strong>Horas contrato:</strong><br>
                <?= $horario['horas'] ?>

            </div>

            <div class="col-3">

                <strong>Profesor guía:</strong><br>
                <?= $horario['is_teacher'] ? 'Sí' : 'No' ?>

            </div>

        </div>


        <!-- TABLA HORARIO -->

        <div class="table-wrapper">
            <table class="table table-bordered mb-0">

                <thead class="table-light">

                    <tr>
                        <th></th>

                        <?php foreach ($dias as $dia): ?>

                            <th><?= $dia ?></th>

                        <?php endforeach ?>

                    </tr>

                </thead>

                <tbody>

                    <!-- ENTRADA MAÑANA -->

                    <tr>

                        <td><strong>Entrada Mañana</strong></td>

                        <?php foreach ($dias as $key => $dia): ?>

                            <td><?= $horario[$key . '_entrada_manana'] ?></td>

                        <?php endforeach ?>

                    </tr>

                    <!-- SALIDA MAÑANA -->

                    <tr>

                        <td><strong>Salida Mañana</strong></td>

                        <?php foreach ($dias as $key => $dia): ?>

                            <td><?= $horario[$key . '_salida_manana'] ?></td>

                        <?php endforeach ?>

                    </tr>

                    <!-- TOTAL MAÑANA -->

                    <tr class="table-secondary">

                        <td><strong>Total Mañana</strong></td>

                        <?php foreach ($dias as $key => $dia):

                            $minManana = calcularMinutos(
                                $horario[$key . '_entrada_manana'],
                                $horario[$key . '_salida_manana']
                            );

                        ?>

                            <td><?= formatearHoras($minManana) ?></td>

                        <?php endforeach ?>

                    </tr>

                    <!-- ENTRADA TARDE -->

                    <tr>

                        <td><strong>Entrada Tarde</strong></td>

                        <?php foreach ($dias as $key => $dia): ?>

                            <td><?= $horario[$key . '_entrada_tarde'] ?></td>

                        <?php endforeach ?>

                    </tr>

                    <!-- SALIDA TARDE -->

                    <tr>

                        <td><strong>Salida Tarde</strong></td>

                        <?php foreach ($dias as $key => $dia): ?>

                            <td><?= $horario[$key . '_salida_tarde'] ?></td>

                        <?php endforeach ?>

                    </tr>

                    <!-- TOTAL TARDE -->

                    <tr class="table-secondary">

                        <td><strong>Total Tarde</strong></td>

                        <?php foreach ($dias as $key => $dia):

                            $minTarde = calcularMinutos(
                                $horario[$key . '_entrada_tarde'],
                                $horario[$key . '_salida_tarde']
                            );

                        ?>

                            <td><?= formatearHoras($minTarde) ?></td>

                        <?php endforeach ?>

                    </tr>

                    <!-- TOTAL DIA -->

                    <tr class="table-primary">

                        <td><strong>Total Día</strong></td>

                        <?php foreach ($dias as $key => $dia):

                            $minManana = calcularMinutos(
                                $horario[$key . '_entrada_manana'],
                                $horario[$key . '_salida_manana']
                            );

                            $minTarde = calcularMinutos(
                                $horario[$key . '_entrada_tarde'],
                                $horario[$key . '_salida_tarde']
                            );

                            $minDia = $minManana + $minTarde;

                            $totalSemanal += $minDia;

                        ?>

                            <td><strong><?= formatearHoras($minDia) ?></strong></td>

                        <?php endforeach ?>

                    </tr>

                </tbody>

            </table>
        </div>

        <?php

        $minContrato = $horario['horas'] * 60;

        if ($horario['is_teacher']) {
            $minContrato -= 30;
        }

        $diferencia = $totalSemanal - $minContrato;

        ?>

        <!-- TOTALES -->

        <div class="text-end mt-4">

            <h5>

                Total semanal trabajado:

                <strong><?= formatearHoras($totalSemanal) ?></strong>

            </h5>

            <?php if ($diferencia == 0): ?>

                <span class="text-success fw-bold">
                    ✔ Horas correctas
                </span>

            <?php elseif ($diferencia > 0): ?>

                <span class="text-warning fw-bold">
                    Sobran <?= formatearHoras($diferencia) ?>
                </span>

            <?php else: ?>

                <span class="text-danger fw-bold">
                    Faltan <?= formatearHoras(abs($diferencia)) ?>
                </span>

            <?php endif ?>

        </div>


        <!-- FIRMAS -->

        <div class="row firmas text-center">

            <div class="col-6">

                <div class="firma-linea"></div>

                Funcionario

            </div>

            <div class="col-6">

                <div class="firma-linea"></div>

                Convivencia Escolar

            </div>

        </div>

    </div>


    <script>
        /* imprimir automaticamente */

        window.onload = function() {

            setTimeout(function() {

                window.print();

            }, 400);

        };

        /* cerrar ventana luego de imprimir */

        window.onafterprint = function() {

            window.close();

        };
    </script>


</body>

</html>