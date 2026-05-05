<?php
class Database {
    private $host = "localhost";
    private $db_name = "control_finanzas";
    private $username = "root"; 
    private $password = "";     // En XAMPP la contraseña viene vacía por defecto
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            // Configuramos PDO para que nos lance excepciones si hay errores
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $exception) {
            echo "Error de conexión: " . $exception->getMessage();
        }
        return $this->conn;
    }
}
?>