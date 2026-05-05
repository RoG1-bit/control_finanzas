<?php
// 1. Iniciamos la "sesión". Esto permite que el servidor recuerde quién entró.
session_start();

// 2. Traemos la clase que creaste en el paso anterior.
require_once 'clases/Login.php';

$mensaje = ''; // Aquí guardaremos el texto de error si se equivocan de clave.

// 3. Verificamos si el usuario presionó el botón de "Ingresar" (Método POST).
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $login = new Login(); // Instanciamos tu clase
    
    // Recogemos lo que escribieron en las cajas de texto
    $usuario = trim($_POST['usuario']);
    $password = trim($_POST['password']);

    // Usamos la función 'autenticar' para ver si los datos coinciden con la BD
    if ($login->autenticar($usuario, $password)) {
        // ¡Éxito! Guardamos el nombre en la sesión y lo enviamos al Dashboard
        $_SESSION['usuario'] = $usuario;
        header("Location: dashboard.php");
        exit;
    } else {
        // Falló. Preparamos un mensaje de error.
        $mensaje = "Usuario o contraseña incorrectos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - Control de Finanzas</title>
    <!-- Aqui va tu parte  integrante 5  -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f9;">
    
    <!-- Contenedor del formulario (caja blanca centrada) -->
    <div style="width: 300px; margin: 100px auto; background: white; text-align: center; border: 1px solid #ccc; border-radius: 8px; padding: 20px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
        <h2 style="color: #333;">Iniciar Sesión</h2>
        
        <?php 
        // Si la variable $mensaje tiene algo (es decir, hubo error), lo mostramos en rojo.
        if($mensaje != '') {
            echo "<p style='color:red; font-size: 14px;'>$mensaje</p>"; 
        }
        ?>
        
        <!-- El formulario envía los datos por el método POST a esta misma página -->
        <form method="POST" action="">
            <div style="margin-bottom: 15px;">
                <input type="text" name="usuario" placeholder="Usuario" required style="width: 90%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
            </div>
            <div style="margin-bottom: 20px;">
                <input type="password" name="password" placeholder="Contraseña" required style="width: 90%; padding: 10px; border: 1px solid #ccc; border-radius: 4px;">
            </div>
            <button type="submit" style="padding: 10px 20px; background-color: #0056b3; color: white; border: none; border-radius: 4px; cursor: pointer; width: 100%;">Ingresar</button>
        </form>
        
        <p style="font-size: 12px; color: #666; margin-top: 15px;">Prueba con admin / 123456</p>
    </div>

</body>
</html>