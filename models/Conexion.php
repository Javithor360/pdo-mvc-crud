<?php 

class Conexion {
    private $host = "localhost:3306";
    private $user = "root";
    private $password = "";
    private $database = "dss_desafio2";
    private $pdo;

    public function __construct() {
        try {
            $this->pdo = new PDO("mysql:host=$this->host;dbname=$this->database", $this->user, $this->password);
        } catch (PDOException $e) {
            echo "Error de conexión: " . $e->getMessage();
            die();
        }
    }

    public function disconnect() {
        $this->pdo = null;
    }

    public function connect() {
        return $this->pdo;
    }
}
