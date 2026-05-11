<?php
include 'config.php';
// Consulta para obtener las entradas de la tabla
$stmt = $pdo->query("SELECT * FROM entradas");
$entradas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Veeeeer Entradas</title>
    <style>
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 10px; }
        th { background-color: #28a745; color: white; }
        /* Ajustamos el tamaño para que se vea mejor la miniatura */
        .foto { width: 60px; height: auto; border-radius: 4px; cursor: pointer; border: 1px solid #ccc; }
        .foto:hover { opacity: 0.8; }
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
<body style="padding: 20px; font-family: Arial;">
    <h2>Historial de Entradas</h2>
    <table>
        <tr>
            <th>Tipo</th>
            <th>Monto</th>
            <th>Fecha</th>
            <th>Foto (Clic para ver)</th>
        </tr>
        <?php foreach ($entradas as $row): ?>
        <tr>
            <td><?php echo htmlspecialchars($row['tipo']); ?></td>
            <td>$<?php echo number_format($row['monto'], 2); ?></td>
            <td><?php echo $row['fecha']; ?></td>
            <td>
                <img src="<?php echo $row['factura_ruta']; ?>" 
                     class="foto" 
                     onclick="window.open(this.src)" 
                     title="Ver factura en grande">
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
      <a href="dashboard.php" class="volver">
        ← Volver al Dashboard
    </a>
</body>
</html>