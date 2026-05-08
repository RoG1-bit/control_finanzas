<?php
require_once __DIR__ . '/../config.php';

class Entrada {
    private $tipo;
    private $monto;
    private $fecha;
    private $ruta_factura;
    private $usuario_id;

    public function __construct($tipo, $monto, $fecha, $ruta_factura, $usuario_id) {
        $this->tipo = $tipo;
        $this->monto = $monto;
        $this->fecha = $fecha;
        $this->ruta_factura = $ruta_factura;
        $this->usuario_id = $usuario_id;
    }

    public function guardar() {
        global $pdo;
        $sql = "INSERT INTO entradas (tipo, monto, fecha, factura_ruta, usuario_id) 
                VALUES (:tipo, :monto, :fecha, :factura_ruta, :usuario_id)";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            ':tipo' => $this->tipo,
            ':monto' => $this->monto,
            ':fecha' => $this->fecha,
            ':factura_ruta' => $this->ruta_factura,
            ':usuario_id' => $this->usuario_id
        ]);
    }
}
?>