<?php 

require_once("Conexion.php");

class Product {
    private $id;
    private $owner_id;
    private $name;
    private $description;
    private $created_at;
    private $conexion;

    public function __construct($id, $owner_id, $name, $description, $created_at) {
        $this->id = $id;
        $this->owner_id = $owner_id;
        $this->name = $name;
        $this->description = $description;
        $this->created_at = $created_at;
        $this->conexion = new Conexion(); // Instanciando la clase Conexion
    }

    public function fetchProducts() {
        $pdo = $this->conexion->connect(); // Conectando a la base de datos
        $query = "SELECT * FROM `product`"; // Query para obtener todos los productos
        $stmt = $pdo->prepare($query); // Preparando la consulta
        $stmt->execute(); // Ejecutando la consulta
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC); // Obteniendo los productos
        $this->conexion->disconnect(); // Cerrando la conexión con la base de datos
        return $products; // Retornando los productos
    }

    public function saveProduct() {
        try {
            $pdo = $this->conexion->connect(); // Conectando a la base de datos
            $query = "INSERT INTO `product` (product_owner, `name`, `description`) VALUES (:product_owner, :name, :description)"; // Query para insertar un producto
            $stmt = $pdo->prepare($query); // Preparando la consulta
            $stmt->bindParam(':product_owner', $this->owner_id); // Asignando los valores a los parametros
            $stmt->bindParam(':name', $this->name);
            $stmt->bindParam(':description', $this->description);
            $result = $stmt->execute(); // Ejecutando la consulta

            if ($result) {
                // Cerrando la conexión con la base de datos
                $this->conexion->disconnect(); 
                return true; // Retornando true si la consulta se ejecuta correctamente
            } else {
                return false; // Retornando false si la consulta no se ejecuta correctamente
            }
        } catch (Exception $e) {
            $error = 'Error: ' . $e->getMessage();
            return $error;
        }
    }

    public function editProductInfo() {
        try {
            $pdo = $this->conexion->connect(); // Conectando a la base de datos
            $query = "UPDATE `product` SET `product_owner` = :product_owner, `name` = :name, `description` = :description WHERE id = :id"; // Query para actualizar la información de un producto
            $stmt = $pdo->prepare($query); // Preparando la consulta
            $stmt->bindParam(':id', $this->id); // Asignando los valores a los parametros
            $stmt->bindParam(':name', $this->name);
            $stmt->bindParam(':product_owner', $this->owner_id);
            $stmt->bindParam(':description', $this->description);
            $result = $stmt->execute(); // Ejecutando la consulta

            if ($result) {
                // Cerrando la conexión con la base de datos
                $this->conexion->disconnect(); 
                return true; // Retornando true si la consulta se ejecuta correctamente
            } else {
                return false; // Retornando false si la consulta no se ejecuta correctamente
            }
        } catch (Exception $e) {
            $error = 'Error: ' . $e->getMessage();
            return $error;
        }
    }

    public function deleteProductFromId() {
        try {
            $pdo = $this->conexion->connect(); // Conectando a la base de datos
            $query = "DELETE FROM `product` WHERE id = :id"; // Query para eliminar un producto
            $stmt = $pdo->prepare($query); // Preparando la consulta
            $stmt->bindParam(':id', $this->id); // Asignando los valores a los parametros
            $result = $stmt->execute(); // Ejecutando la consulta

            if ($result) {
                // Cerrando la conexión con la base de datos
                $this->conexion->disconnect(); 
                return true; // Retornando true si la consulta se ejecuta correctamente
            } else {
                return false; // Retornando false si la consulta no se ejecuta correctamente
            }
        } catch (Exception $e) {
            $error = 'Error: ' . $e->getMessage();
            return $error;
        }
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
    }
}