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
<html>

<head>

    <meta charset="UTF-8">
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
    <style>
        @page {
            size: Letter;
            margin: 2cm;
        }

        .page {
            page-break-after: always;
        }
    </style>

</head>

<body>

    <?php foreach ($lista as $item): ?>

        <div class="page">

            <?= view('imprimir', [
                'usuario' => $item['usuario'],
                'horario' => $item['horario'],
                'dias' => $dias,
                'totalSemanal' => $totalSemanal
            ]) ?>

        </div>

    <?php endforeach; ?>


    <script>
        window.onload = function() {

            setTimeout(function() {
                window.print();
            }, 500);

        };

        window.onafterprint = function() {
            window.close();
        };
    </script>

</body>

</html>