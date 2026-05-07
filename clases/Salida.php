<?php
class Salida {
    private $tipo;
    private $monto;
    private $fecha;
    private $factura_ruta;

    public function __construct($tipo, $monto, $fecha, $factura_ruta) {
        $this->tipo = $tipo;
        $this->monto = $monto;
        $this->fecha = $fecha;
        $this->factura_ruta = $factura_ruta;
    }

    public function guardar() {
        global $pdo; // Usa la conexión de config.php
        try {
            $usuario_id = $_SESSION['usuario_id'] ?? 1; // Ajustado según lo que pidió Iván
            $sql = "INSERT INTO salidas (tipo, monto, fecha, factura_ruta, usuario_id) VALUES (?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            return $stmt->execute([$this->tipo, $this->monto, $this->fecha, $this->factura_ruta, $usuario_id]);
        } catch (PDOException $e) {
            error_log("Error en Salida::guardar: " . $e->getMessage());
            return false;
        }
    }
}
?>