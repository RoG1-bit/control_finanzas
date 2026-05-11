<?php

session_start();

include 'config.php';
include 'clases/ReporteBalance.php';

require 'vendor/autoload.php';

$grafico = $_POST['grafico'] ?? '';

use Dompdf\Dompdf;

$desde = date('Y-m-01');
$hasta = date('Y-m-t');

$reporte = new ReporteBalance($pdo, $desde, $hasta);

$reporte->generar();

$entradas = $reporte->getEntradas();
$salidas = $reporte->getSalidas();

$balance = $reporte->getBalance();

$dompdf = new Dompdf();

    $tablaEntradas = '';

    foreach($entradas as $e){

        $tablaEntradas .= '
        
        <tr>
            <td>'.htmlspecialchars($e['tipo']).'</td>
            <td>$ '.number_format($e['monto'],2).'</td>
        </tr>

        ';
    }

$tablaSalidas = '';

foreach($salidas as $s){

    $tablaSalidas .= '
    
    <tr>
        <td>'.htmlspecialchars($s['tipo']).'</td>
        <td>$ '.number_format($s['monto'],2).'</td>
    </tr>

    ';
}


$html = '

<style>

body{
    font-family: Arial;
    font-family: Arial, sans-serif;
}


h1{
    text-align:center;
    color:#2c3e50;
}

table{
    width:100%;
    border-collapse:collapse;
    margin-bottom:20px;
}

th{
    background:#3498db;
    color:white;
    padding:10px;
}

td{
    border:1px solid #ccc;
    padding:10px;
    text-align:center;
}

.balance{
    background:#2ecc71;
    color:white;
    padding:15px;
    text-align:center;
    font-size:20px;
    font-weight:bold;
}

</style>

<h1>Reporte Balance</h1>

<h2>Entradas</h2>

<table>

<tr>
<th>Tipo</th>
<th>Monto</th>
</tr>

'.$tablaEntradas.'

</table>

<h2>Salidas</h2>

<table>

<tr>
<th>Tipo</th>
<th>Monto</th>
</tr>

'.$tablaSalidas.'

</table>

<div class="balance">
Balance Total: $ '.number_format($balance,2).'
</div>


<div style="text-align:center;">
    <h2>Gráfico Entradas y Salidas</h2> 
    <img src="'.$grafico.'" width="400">
</div>
';

$dompdf->loadHtml($html);

$dompdf->setPaper('A4', 'portrait');

$dompdf->render();

$fecha = date("Y-m-d");

$dompdf->stream("reporte_$fecha.pdf");

?>