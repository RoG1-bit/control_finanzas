<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Registrar Entrada</title>

    <style>

        body{
            font-family: Arial, sans-serif;
            background:#eef2f7;
            margin:0;
            padding:30px;
        }

        .contenedor{
            max-width:600px;
            margin:auto;
            background:white;
            padding:30px;
            border-radius:15px;
            box-shadow:0px 4px 10px rgba(0,0,0,0.1);
        }

        h2{
            text-align:center;
            color:#27ae60;
            margin-bottom:25px;
        }

        label{
            display:block;
            margin-top:15px;
            margin-bottom:8px;
            font-weight:bold;
            color:#2c3e50;
        }

        input{
            width:100%;
            padding:12px;
            border:1px solid #ccc;
            border-radius:8px;
            box-sizing:border-box;
        }

        input:focus{
            outline:none;
            border-color:#27ae60;
        }

        button{
            width:100%;
            background:#27ae60;
            color:white;
            border:none;
            padding:15px;
            margin-top:25px;
            border-radius:10px;
            font-size:16px;
            font-weight:bold;
            cursor:pointer;
            transition:0.3s;
        }

        button:hover{
            background:#219150;
        }

        .volver{
            display:inline-block;
            margin-top:20px;
            text-decoration:none;
            background:#34495e;
            color:white;
            padding:12px 18px;
            border-radius:8px;
            transition:0.3s;
        }

        .volver:hover{
            background:#2c3e50;
        }

    </style>

</head>

<body>

<div class="contenedor">

    <h2>Registrar Entrada</h2>

    <form action="procesar_entrada.php" method="POST" enctype="multipart/form-data">

        <label>Tipo de entrada</label>
        <input type="text" name="tipo" required>

        <label>Monto ($)</label>
        <input type="number" step="0.01" name="monto" required>

        <label>Fecha</label>
        <input type="date" name="fecha" required>

        <label>Factura (foto)</label>
        <input type="file" name="factura" accept="image/*" required>

        <button type="submit">
            Guardar Entrada
        </button>

    </form>

    <a href="dashboard.php" class="volver">
        ← Volver al Dashboard
    </a>

</div>

</body>
</html>