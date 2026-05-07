<?php
require_once __DIR__ . '/../config.php';

class Entrada {
    private $tipo;
    private $monto;
    private $fecha;
    private $ruta_factura;

    public function __construct($tipo, $monto, $fecha, $ruta_factura) {
        $this->tipo = $tipo;
        $this->monto = $monto;
        $this->fecha = $fecha;
        $this->ruta_factura = $ruta_factura;
    }

    public function guardar() {
        global $pdo;
        $sql = "INSERT INTO entradas (tipo, monto, fecha, factura_ruta) 
                VALUES (:tipo, :monto, :fecha, :factura_ruta)";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            ':tipo' => $this->tipo,
            ':monto' => $this->monto,
            ':fecha' => $this->fecha,
            ':factura_ruta' => $this->ruta_factura
        ]);
    }
}
?>