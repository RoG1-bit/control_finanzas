    <?php

    session_start();

    if (!isset($_SESSION['usuario'])) {
        header("Location: index.php");
        exit;
    }

        include 'config.php';
        include 'clases/ReporteBalance.php';

        $desde = $_GET['desde'] ?? date('Y-m-01');
        $hasta = $_GET['hasta'] ?? date('Y-m-t');

        $reporte = new ReporteBalance($pdo, $desde, $hasta);
        $reporte->generar();

        $entradas = $reporte->getEntradas();
        $salidas = $reporte->getSalidas();

        $totalEntradas = $reporte->getTotalEntradas();
        $totalSalidas = $reporte->getTotalSalidas();

        $balance = $reporte->getBalance();

    ?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Reporte Balance</title>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>

        body{
            font-family: Arial, sans-serif;
            background: #eef2f7;
            margin:0;
            padding:30px;
        }

        .contenedor{
            width: 90%;
            max-width: 1000px;
            margin:auto;
            background:white;
            padding:30px;
            border-radius:15px;
            box-shadow:0px 4px 10px rgba(0,0,0,0.1);
        }

        h1{
            text-align:center;
            color:#2c3e50;
            margin-bottom:30px;
        }

        h2{
            color:#34495e;
        }

        table{
            width:100%;
            border-collapse: collapse;
            margin-bottom:30px;
            overflow:hidden;
            border-radius:10px;
        }

        th{
            background:#3498db;
            color:white;
            padding:12px;
        }

        td{
            padding:10px;
            border-bottom:1px solid #ddd;
            text-align:center;
        }

        tr:hover{
            background:#f5f5f5;
        }

        .balance{
            background:#2ecc71;
            color:white;
            padding:15px;
            text-align:center;
            border-radius:10px;
            margin-bottom:30px;
            font-size:22px;
            font-weight:bold;
        }

        canvas{
            max-width:400px;
            margin:auto;
            display:block;
        }

        .boton-pdf{
            display:block;
            width:220px;
            margin:30px auto;
            background:#e74c3c;
            color:white;
            text-align:center;
            padding:15px;
            border:none;
            border-radius:10px;
            font-weight:bold;
            cursor:pointer;
            transition:0.3s;
        }

        .boton-pdf:hover{
            background:#c0392b;
        }

        .boton-volver{
            display:inline-block;
            background:#34495e;
            color:white;
            padding:12px 20px;
            text-decoration:none;
            border-radius:10px;
            margin-bottom:20px;
            transition:0.3s;
            font-weight:bold;
        }

        .boton-volver:hover{
            background:#2c3e50;
        }

    </style>

</head>

<body>

<div class="contenedor">

    <a href="dashboard.php" class="boton-volver">
        ← Volver al Dashboard
    </a>

    <h1>Reporte Balance</h1>

    <h2>Entradas</h2>

    <table>

        <thead>
            <tr>
                <th>Tipo</th>
                <th>Monto</th>
            </tr>
        </thead>

        <tbody>

        <?php foreach($entradas as $e): ?>

            <tr>
                <td><?= htmlspecialchars($e['tipo']) ?></td>
                <td>$ <?= number_format($e['monto'],2) ?></td>
            </tr>

        <?php endforeach; ?>

        </tbody>

    </table>

    <h2>Salidas</h2>

    <table>

        <thead>
            <tr>
                <th>Tipo</th>
                <th>Monto</th>
            </tr>
        </thead>

        <tbody>

        <?php foreach($salidas as $s): ?>

            <tr>
                <td><?= htmlspecialchars($s['tipo']) ?></td>
                <td>$ <?= number_format($s['monto'],2) ?></td>
            </tr>

        <?php endforeach; ?>

        </tbody>

    </table>

    <div class="balance">
        Balance Total: $ <?= number_format($balance,2) ?>
    </div>

    <canvas id="grafico"></canvas>

    <form action="exportar_pdf.php" method="POST" id="formPDF">

        <input type="hidden" name="grafico" id="graficoInput">

        <button type="submit" class="boton-pdf">
            Exportar PDF
        </button>

    </form>

</div>

<script>

const ctx = document.getElementById('grafico');

new Chart(ctx, {
    type: 'pie',

    data: {
        labels: ['Entradas', 'Salidas'],

        datasets: [{
            data: [
                <?= $totalEntradas ?>,
                <?= $totalSalidas ?>
            ]
        }]
    }
});

document.getElementById("formPDF").addEventListener("submit", function(){

    const canvas = document.getElementById("grafico");

    const imagenBase64 = canvas.toDataURL("image/png");

    document.getElementById("graficoInput").value = imagenBase64;

});

</script>

</body>
</html>