<?php
session_start();
if (!isset($_SESSION['usuario'])) { header("Location: index.php"); exit; }
include 'config.php';

$desde = $_GET['desde'] ?? date('Y-m-01');
$hasta = $_GET['hasta'] ?? date('Y-m-t');

$stmt = $pdo->prepare("SELECT * FROM salidas WHERE fecha BETWEEN :d AND :h ORDER BY fecha DESC");
$stmt->execute([':d' => $desde, ':h' => $hasta]);
$salidas = $stmt->fetchAll(PDO::FETCH_ASSOC);
$total   = array_sum(array_column($salidas, 'monto'));
?>
<!DOCTYPE html><html lang="es"><head><meta charset="UTF-8">
<title>Ver Salidas</title>

<style>
    body{font-family:Arial,sans-serif;background:#f4f4f9;padding:20px}
    h2{color:#c0392b}
    form{margin-bottom:16px;display:flex;gap:10px;flex-wrap:wrap;align-items:flex-end}
    label{font-size:.85rem;font-weight:bold}
    input[type=date]{padding:6px 10px;border:1px solid #ccc;border-radius:4px;display:block;margin-top:3px}
    button{padding:7px 16px;background:#c0392b;color:#fff;border:none;border-radius:4px;cursor:pointer}
    table{width:100%;border-collapse:collapse;background:#fff;border-radius:8px;overflow:hidden;box-shadow:0 2px 6px rgba(0,0,0,.1)}
    th{background:#c0392b;color:#fff;padding:10px;text-align:left}
    td{padding:9px 10px;border-bottom:1px solid #eee;vertical-align:middle}
    tr:nth-child(even) td{background:#fff5f5}
    .monto{text-align:right;font-weight:bold;color:#c0392b}
    tfoot td{background:#fce4e4;font-weight:bold}
    .img-fact{width:54px;height:54px;object-fit:cover;border-radius:4px;border:1px solid #ccc;cursor:pointer}
    .img-fact:hover{opacity:.8;transform:scale(1.05)}
    .nav{margin-bottom:16px}
    .nav a{color:#0056b3;text-decoration:none;margin-right:12px;font-size:.9rem;font-weight:bold}
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


<h2> Ver Salidas</h2>

<form method="get">
  <div><label>Desde<input type="date" name="desde" value="<?= htmlspecialchars($desde) ?>"></label></div>
  <div><label>Hasta<input type="date" name="hasta" value="<?= htmlspecialchars($hasta) ?>"></label></div>
  <button>Filtrar</button>
</form>

<table>
  <thead><tr><th>#</th><th>Tipo / Descripción</th><th>Fecha</th><th>Factura</th><th class="monto">Monto ($)</th></tr></thead>
  <tbody>
  <?php if (!$salidas): ?>
    <tr><td colspan="5" style="text-align:center;padding:28px;color:#aaa">Sin registros en el período.</td></tr>
  <?php else: foreach ($salidas as $i => $s): ?>
    <tr>
      <td><?= $i+1 ?></td>
      <td><?= htmlspecialchars($s['tipo']) ?></td>
      <td><?= $s['fecha'] ?></td>
      <td>
        <?php if (!empty($s['factura_ruta'])): ?>
          <img src="<?= htmlspecialchars($s['factura_ruta']) ?>" class="img-fact"
               onclick="window.open(this.src)" title="Clic para ampliar">
        <?php else: ?>
          <span style="color:#aaa">—</span>
        <?php endif; ?>
      </td>
      <td class="monto">$ <?= number_format($s['monto'],2) ?></td>
    </tr>
  <?php endforeach; endif; ?>
  </tbody>
  <?php if ($salidas): ?>
  <tfoot><tr>
    <td colspan="3"></td>
    <td style="text-align:right">Total salidas:</td>
    <td class="monto">$ <?= number_format($total,2) ?></td>
  </tr></tfoot>
  <?php endif; ?>
</table>

  <a href="dashboard.php" class="volver">
        ← Volver al Dashboard
    </a>
</body></html>
