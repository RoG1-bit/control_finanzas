<?php
session_start();
// Verifica la sesión como en el código de Iván
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Regissssstrar Salida</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body style="font-family: Arial; background-color: #f4f4f9; padding: 20px;">
<div style="max-width: 600px; margin: auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
    <h2>Registrar Salida</h2>
    <form action="procesar_salida.php" method="POST" enctype="multipart/form-data">
        <label>Tipo de salida:</label>
        <input type="text" name="tipo" style="width: 100%; margin-bottom: 15px;" required>

        <label>Monto ($):</label>
        <input type="number" step="0.01" name="monto" style="width: 100%; margin-bottom: 15px;" required>

        <label>Fecha:</label>
        <input type="date" name="fecha" style="width: 100%; margin-bottom: 15px;" required>

        <label>Factura (foto):</label>
        <input type="file" name="factura" accept="image/*" style="width: 100%; margin-bottom: 15px;" required>

        <button type="submit" style="background: #e74c3c; color: white; padding: 10px; width: 100%; border: none; cursor: pointer;">Guardar Salida</button>
    </form>
</div>
</body>
</html>