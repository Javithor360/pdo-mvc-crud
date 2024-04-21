<?php 

require_once("Conexion.php");

class User {
    private $id;
    private $name;
    private $username;
    private $password;
    private $created_at;
    private $conexion;

    public function __construct($id, $name, $username, $password, $created_at) {
        $this->id = $id;
        $this->name = $name;
        $this->username = $username;
        $this->password = $password;
        $this->created_at = $created_at;
        $this->conexion = new Conexion(); // Instanciando la clase Conexion
    }

    public function saveUser() {
        try {
            $pdo = $this->conexion->connect(); // Conectando a la base de datos
            $query = "INSERT INTO `user` (name, username, password) VALUES (:name, :username, :password)"; // Query para insertar un usuario
            $stmt = $pdo->prepare($query); // Preparando la consulta
            $stmt->bindParam(':name', $this->name); // Asignando los valores a los parametros
            $stmt->bindParam(':username', $this->username);
            $stmt->bindParam(':password', $this->password);
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

    public function getUserByCredentials($username, $password) {
        try {
            $pdo = $this->conexion->connect(); // Conectar a la base de datos
            $query = "SELECT * FROM `user` WHERE username = :username AND `password` = :password"; // Consulta para obtener el usuario por nombre de usuario y contraseña
            $stmt = $pdo->prepare($query); // Preparar la consulta
            $stmt->bindParam(':username', $username); // Enlazar el parámetro de nombre de usuario
            $stmt->bindParam(':password', $password); // Enlazar el parámetro de contraseña
            $stmt->execute(); // Ejecutar la consulta
            $user = $stmt->fetch(PDO::FETCH_ASSOC); // Obtener los datos del usuario
            $this->conexion->disconnect(); // Cerrar la conexión con la base de datos

            // Verificar si se encontró el usuario
            if ($user) {
                return $user; // Devolver los datos del usuario
            } else {
                return false; // Usuario no encontrado o contraseña incorrecta
            }
        } catch (Exception $e) {
            $error = 'Error: ' . $e->getMessage();
            return $error;
        }
    }
    
    public function fetchUsers() {
        $pdo = $this->conexion->connect(); // Conectando a la base de datos
        $query = "SELECT * FROM `user`"; // Query para obtener todos los usuarios
        $stmt = $pdo->prepare($query); // Preparando la consulta
        $stmt->execute(); // Ejecutando la consulta
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC); // Obteniendo todos los usuarios
        $this->conexion->disconnect(); // Cerrando la conexión con la base de datos
        return $users; // Retornando todos los usuarios
    }

    public function fetchAllUserNamesWithIds() {
        try {
            $pdo = $this->conexion->connect(); // Conectando a la base de datos
            $query = "SELECT `id`, `name` FROM `user`"; // Query para obtener todos los IDs y nombres de usuario
            $stmt = $pdo->prepare($query); // Preparando la consulta
            $stmt->execute(); // Ejecutando la consulta
            $userNamesWithIds = $stmt->fetchAll(PDO::FETCH_KEY_PAIR); // Obteniendo todos los IDs y nombres de usuario
            $this->conexion->disconnect(); // Cerrando la conexión con la base de datos
            return $userNamesWithIds; // Retornando los IDs y nombres de usuario
        } catch (Exception $e) {
            $error = 'Error: ' . $e->getMessage();
            return $error;
        }
    }

    public function editUserInfo() {
        try {
            $pdo = $this->conexion->connect(); // Conectando a la base de datos
            $query = "UPDATE `user` SET name = :name, username = :username WHERE id = :id"; // Query para actualizar la información del usuario
            $stmt = $pdo->prepare($query); // Preparando la consulta
            $stmt->bindParam(':name', $this->name); // Asignando los valores a los parametros
            $stmt->bindParam(':username', $this->username);
            $stmt->bindParam(':id', $this->id);
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
    
    public function deleteUserFromId() {
        try {
            $pdo = $this->conexion->connect(); // Conectando a la base de datos
            $query = "DELETE FROM `user` WHERE id = :id"; // Query para eliminar un usuario
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

    public function getUsername() {
        return $this->username;
    }

    public function setUsername($username) {
        $this->username = $username;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        $this->password = $password;
    }
}
