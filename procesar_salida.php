<?php
session_start();
require_once 'clases/Salida.php';
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tipo = trim($_POST['tipo'] ?? '');
    $monto = floatval($_POST['monto'] ?? 0);
    $fecha = $_POST['fecha'] ?? '';

    if (empty($tipo) || $monto <= 0 || empty($fecha)) {
        die("Todos los campos son obligatorios.");
    }

    $directorio = "assets/uploads/facturas/";
    if (!is_dir($directorio)) {
        mkdir($directorio, 0777, true);
    }

    $archivo = $_FILES['factura'];
    $nombreArchivo = time() . "_" . basename($archivo['name']);
    $rutaDestino = $directorio . $nombreArchivo;

    if (move_uploaded_file($archivo['tmp_name'], $rutaDestino)) {
        $salida = new Salida($tipo, $monto, $fecha, $rutaDestino);
        if ($salida->guardar()) {
            echo "✅ Salida registrada. <a href='dashboard.php'>Volver</a>";
        } else {
            echo "❌ Error en la base de datos.";
        }
    } else {
        echo "❌ Error al subir la imagen.";
    }
} else {
    header("Location: registrar_salida.php");
}
?>