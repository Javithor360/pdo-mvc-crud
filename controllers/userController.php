<?php 

require_once("../models/userModel.php");

$controller = new UserController();

if (isset($_POST['action']) || isset($_GET['action'])) {
    $action = $_POST['action'] ?? $_GET['action'];
    if (method_exists($controller, $action)) {
        $controller->$action();
    } else {
        echo "Error: No existe el método $action en el controlador";
    }
}

class UserController {
    public static function getUsers() {
        $userModel = new User(null, null, null, null, null);
        return $userModel->fetchUsers();
    }

    public static function getAllUserNames() {
        $userModel = new User(null, null, null, null, null);
        return $userModel->fetchAllUserNamesWithIds();
    }

    public function update() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (
                empty($_POST["name"]) ||
                empty($_POST["username"]) ||
                empty($_POST["id"])
            ) {
                header("Location: ../views/users.php?info=error_empty_fields");
                exit();
            } else {
                $id = $_POST["id"];
                $name = $_POST["name"];
                $username = $_POST["username"];
                $user = new User($id, $name, $username, null, null);
                if ($user->editUserInfo() === true) {
                    header("Location: ../views/users.php?info=success_update");
                } else {
                    header("Location: ../views/users.php?info=error_update");
                }
                exit();
            }
        }
    }

    public function delete() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (empty($_POST["id"])) {
                header("Location: ../views/users.php?info=error_empty_fields");
                exit();
            } else {
                $id = $_POST["id"];
                $user = new User($id, null, null, null, null);
                if ($user->deleteUserFromId() === true) {
                    header("Location: ../views/users.php?info=success_delete");
                } else {
                    header("Location: ../views/users.php?info=error_delete");
                }
                exit();
            }
        }
    }
}