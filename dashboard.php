<?php
session_start();

// SEGURIDAD: Validar que el usuario haya iniciado sesión correctamente
// Si intentan entrar a dashboard.php directamente sin loguearse, los devuelve al index
if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit;
}

// Lógica para cerrar sesión si hacen clic en el botón rojo
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Control de Finanzas</title>
    <!-- parte de los estilos -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f9; margin: 0; padding: 20px;">
    
    <div style="max-width: 800px; margin: 40px auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
        
        <!-- Encabezado con Bienvenida -->
        <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #0056b3; padding-bottom: 15px; margin-bottom: 20px;">
            <h1 style="color: #333; margin: 0;">Bienvenido, <?php echo htmlspecialchars($_SESSION['usuario']); ?>!</h1>
            <a href="?logout=1" style="color: white; background-color: #dc3545; padding: 8px 15px; text-decoration: none; border-radius: 4px; font-weight: bold;">Cerrar Sesión</a>
        </div>

        <p style="color: #555; font-size: 16px;">Selecciona una opción del menú administrativo:</p>

        <!-- Archivos HREF creados solo de prueba  -->
        <div style="display: flex; flex-direction: column; gap: 10px; margin-top: 20px;">
            <a href="registrar_entrada.php" style="display: block; padding: 15px; background: #e9ecef; text-decoration: none; color: #333; border-radius: 5px; font-weight: bold; border-left: 5px solid #28a745;">1. Registrar entrada</a>
            
            <a href="registrar_salida.php" style="display: block; padding: 15px; background: #e9ecef; text-decoration: none; color: #333; border-radius: 5px; font-weight: bold; border-left: 5px solid #dc3545;">2. Registrar salida</a>
            
            <a href="ver_entradas.php" style="display: block; padding: 15px; background: #e9ecef; text-decoration: none; color: #333; border-radius: 5px; font-weight: bold; border-left: 5px solid #17a2b8;">3. Ver entradas</a>
            
            <a href="ver_salidas.php" style="display: block; padding: 15px; background: #e9ecef; text-decoration: none; color: #333; border-radius: 5px; font-weight: bold; border-left: 5px solid #ffc107;">4. Ver salidas</a>
            
            <a href="mostrar_balance.php" style="display: block; padding: 15px; background: #0056b3; text-decoration: none; color: white; border-radius: 5px; font-weight: bold; text-align: center; margin-top: 10px;">5. Mostrar balance</a>
        </div>
        
    </div>

</body>
</html>