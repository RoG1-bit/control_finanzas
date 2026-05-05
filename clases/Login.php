<?php
require_once 'Database.php';

class Login {
    private $conn;
    private $table_name = "usuarios";

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function autenticar($usuario, $password) {
        $query = "SELECT id, usuario, password FROM " . $this->table_name . " WHERE usuario = :usuario LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        
        $usuario = htmlspecialchars(strip_tags($usuario));
        $stmt->bindParam(':usuario', $usuario);
        
        $stmt->execute();

        if($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if(password_verify($password, $row['password'])) {
                return true;
            }
        }
        return false;
    }
}
?>