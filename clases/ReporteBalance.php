<?php
class ReporteBalance {
    private PDO $pdo;
    private string $desde, $hasta;
    private array $entradas = [], $salidas = [];
    private float $totalE = 0, $totalS = 0;

    public function __construct(PDO $pdo, string $desde = '', string $hasta = '') {
        $this->pdo   = $pdo;
        $this->desde = $desde ?: date('Y-m-01');
        $this->hasta = $hasta ?: date('Y-m-t');
    }

    public function generar(): self {
        $p = [':desde' => $this->desde, ':hasta' => $this->hasta];

        $this->entradas = $this->q(
            "SELECT * FROM entradas WHERE fecha BETWEEN :desde AND :hasta ORDER BY fecha ASC", $p);

        $this->salidas = $this->q(
            "SELECT * FROM salidas WHERE fecha BETWEEN :desde AND :hasta ORDER BY fecha ASC", $p);

        $this->totalE = (float) array_sum(array_column($this->entradas, 'monto'));
        $this->totalS = (float) array_sum(array_column($this->salidas,  'monto'));
        return $this;
    }

    private function q(string $sql, array $p): array {
        $s = $this->pdo->prepare($sql); $s->execute($p);
        return $s->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getEntradas(): array      { return $this->entradas; }
    public function getSalidas():  array      { return $this->salidas; }
    public function getTotalEntradas(): float { return $this->totalE; }
    public function getTotalSalidas():  float { return $this->totalS; }
    public function getBalance():       float { return $this->totalE - $this->totalS; }
}
