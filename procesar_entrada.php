<?php
session_start();
require_once 'clases/Entrada.php';
require_once 'config.php';

if (!isset($_SESSION['usuario'])) {
    die("Debes iniciar sesión. <a href='index.php'>Ir al login</a>");
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Método no permitido.");
}

$tipo = trim($_POST['tipo'] ?? '');
$monto = floatval($_POST['monto'] ?? 0);
$fecha = $_POST['fecha'] ?? '';

if (empty($tipo) || $monto <= 0 || empty($fecha)) {
    die("Todos los campos son obligatorios y el monto debe ser mayor a cero.");
}

// Subir imagen
$directorio = "assets/uploads/facturas/";
if (!is_dir($directorio)) {
    mkdir($directorio, 0777, true);
}

if (!isset($_FILES['factura']) || $_FILES['factura']['error'] !== UPLOAD_ERR_OK) {
    die("Error al subir la imagen. Código: " . ($_FILES['factura']['error'] ?? 'Ningún archivo'));
}

$archivo = $_FILES['factura'];
$nombreArchivo = time() . "_" . basename($archivo['name']);
$rutaDestino = $directorio . $nombreArchivo;

$extension = strtolower(pathinfo($nombreArchivo, PATHINFO_EXTENSION));
if (!in_array($extension, ['jpg', 'jpeg', 'png'])) {
    die("Solo se permiten imágenes JPG, JPEG o PNG.");
}

if (!move_uploaded_file($archivo['tmp_name'], $rutaDestino)) {
    die("No se pudo guardar la imagen.");
}

$entrada = new Entrada($tipo, $monto, $fecha, $rutaDestino);
if ($entrada->guardar()) {
    echo "<div style='text-align:center; margin-top:50px;'>✅ Entrada registrada correctamente.<br>
          <a href='registrar_entrada.php'>Registrar otra</a> | <a href='dashboard.php'>Dashboard</a></div>";
} else {
    echo "❌ Error al guardar en la base de datos.";
}
?>