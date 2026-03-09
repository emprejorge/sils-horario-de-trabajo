<?php

$dias = [
    'lun' => 'Lunes',
    'mar' => 'Martes',
    'mie' => 'Miércoles',
    'jue' => 'Jueves',
    'vie' => 'Viernes'
];

function minutos($inicio, $fin)
{
    if (!$inicio || !$fin) return 0;

    [$h1, $m1] = explode(':', $inicio);
    [$h2, $m2] = explode(':', $fin);

    return ($h2 * 60 + $m2) - ($h1 * 60 + $m1);
}

function horas($min)
{
    if ($min <= 0) return "0:00";

    $h = floor($min / 60);
    $m = $min % 60;

    return $h . ":" . str_pad($m, 2, "0", STR_PAD_LEFT);
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

        .header h3 {
            margin: 0;
        }

        .info {
            margin-bottom: 20px;
        }

        .table th {
            text-align: center;
        }

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
            border-top: 1px solid black;
            width: 250px;
            margin: auto;
            margin-top: 60px;
        }

        .no-print {
            display: none;
        }
    </style>

</head>

<body>

    <div class="container-fluid">

        <!-- ENCABEZADO -->

        <div class="header">

            <h3><strong>SCUOLA ITALIANA LA SERENA</strong></h3>

            <p>
                Sistema de Registro de Horas Laborales
            </p>

            <h5 class="mt-3">
                Horario de Trabajo
            </h5>

        </div>


        <!-- INFORMACION FUNCIONARIO -->

        <div class="row info">

            <div class="col-6">

                <strong>Funcionario:</strong><br>
                <?= session()->get('user')['name'] ?>

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

        <table class="table table-bordered">

            <thead class="table-light">

                <tr>

                    <th></th>

                    <?php foreach ($dias as $dia): ?>

                        <th><?= $dia ?></th>

                    <?php endforeach ?>

                </tr>

            </thead>

            <tbody>

                <tr>

                    <td><strong>Entrada Mañana</strong></td>

                    <?php foreach ($dias as $key => $dia): ?>

                        <td><?= $horario[$key . '_entrada_manana'] ?></td>

                    <?php endforeach ?>

                </tr>

                <tr>

                    <td><strong>Salida Mañana</strong></td>

                    <?php foreach ($dias as $key => $dia): ?>

                        <td><?= $horario[$key . '_salida_manana'] ?></td>

                    <?php endforeach ?>

                </tr>

                <tr class="table-secondary">

                    <td><strong>Total Mañana</strong></td>

                    <?php foreach ($dias as $key => $dia):

                        $m = minutos(
                            $horario[$key . '_entrada_manana'],
                            $horario[$key . '_salida_manana']
                        );

                    ?>

                        <td><?= horas($m) ?></td>

                    <?php endforeach ?>

                </tr>

                <tr>

                    <td><strong>Entrada Tarde</strong></td>

                    <?php foreach ($dias as $key => $dia): ?>

                        <td><?= $horario[$key . '_entrada_tarde'] ?></td>

                    <?php endforeach ?>

                </tr>

                <tr>

                    <td><strong>Salida Tarde</strong></td>

                    <?php foreach ($dias as $key => $dia): ?>

                        <td><?= $horario[$key . '_salida_tarde'] ?></td>

                    <?php endforeach ?>

                </tr>

                <tr class="table-secondary">

                    <td><strong>Total Tarde</strong></td>

                    <?php foreach ($dias as $key => $dia):

                        $t = minutos(
                            $horario[$key . '_entrada_tarde'],
                            $horario[$key . '_salida_tarde']
                        );

                    ?>

                        <td><?= horas($t) ?></td>

                    <?php endforeach ?>

                </tr>

                <tr class="table-primary">

                    <td><strong>Total Día</strong></td>

                    <?php foreach ($dias as $key => $dia):

                        $m = minutos(
                            $horario[$key . '_entrada_manana'],
                            $horario[$key . '_salida_manana']
                        );

                        $t = minutos(
                            $horario[$key . '_entrada_tarde'],
                            $horario[$key . '_salida_tarde']
                        );

                        $d = $m + $t;

                        $totalSemanal += $d;

                    ?>

                        <td><strong><?= horas($d) ?></strong></td>

                    <?php endforeach ?>

                </tr>

            </tbody>

        </table>


        <?php

        if ($horario['is_teacher']) {
            $totalSemanal -= 30;
        }

        ?>

        <div class="text-end mt-3">

            <h5>

                Total semanal:
                <strong><?= horas($totalSemanal) ?></strong>

            </h5>

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
        window.onload = function() {

            setTimeout(function() {

                window.print();

            }, 400);

        };

        /* cerrar ventana despues de imprimir */

        window.onafterprint = function() {

            window.close();

        };
    </script>


</body>

</html>