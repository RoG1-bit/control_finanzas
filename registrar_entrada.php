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
    <title>Registrar Entrada - Finanzas</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f9; margin: 0; padding: 20px;">
<div style="max-width: 600px; margin: 40px auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
    <h2>Registrar Entrada</h2>
    <form action="procesar_entrada.php" method="POST" enctype="multipart/form-data">
        <label>Tipo de entrada:</label>
        <input type="text" name="tipo" required>

        <label>Monto ($):</label>
        <input type="number" step="0.01" name="monto" required>

        <label>Fecha:</label>
        <input type="date" name="fecha" required>

        <label>Factura (foto):</label>
        <input type="file" name="factura" accept="image/jpeg,image/png,image/jpg" required>

        <button type="submit">Guardar Entrada</button>
    </form>
    <br>
    <a href="dashboard.php">← Volver al Dashboard</a>
</div>
</body>
</html>