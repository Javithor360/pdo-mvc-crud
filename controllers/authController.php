<?php

require_once("../models/userModel.php");
require_once("../models/Conexion.php");

$controller = new AuthController();

if (isset($_POST['action']) || isset($_GET['action'])) {
    $action = $_POST['action'] ?? $_GET['action'];
    if (method_exists($controller, $action)) {
        $controller->$action();
    } else {
        echo "Error: No existe el método $action en el controlador";
    }
}

class AuthController
{
    public function register()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (
                empty($_POST["name"]) ||
                empty($_POST["user"]) ||
                empty($_POST["password"]) ||
                empty($_POST["r-password"])
            ) {
                // Redireccionar al formulario de registro con un mensaje de error
                header("Location: ../views/register.php?error=empty_fields");
                exit();
            } else if ($_POST["password"] !== $_POST["r-password"]) {
                header("Location: ../views/register.php?error=password_mismatch");
                exit();
            } else {
                $name = $_POST["name"];
                $user = $_POST["user"];
                $password = $_POST["password"];
                $user = new User(null, $name, $user, $password, null);
                if ($user->saveUser() === true) {
                    header("Location: ../views/login.php?info=success_register");
                } else {
                    header("Location: ../views/register.php?error=register_error");
                }
                exit();
            }
        }
    }

    public function login()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (empty($_POST["user"]) || empty($_POST["password"])) {
                // Redireccionar al formulario de inicio de sesión con un mensaje de error
                header("Location: ../views/login.php?info=error_empty_fields");
                exit();
            } else {
                $user = $_POST["user"];
                $password = $_POST["password"];

                // Instanciar el modelo de usuario
                $userModel = new User(null, null, $user, $password, null);

                // Obtener el usuario por sus credenciales
                $loggedInUser = $userModel->getUserByCredentials($user, $password);
                // var_dump($loggedInUser);

                if ($loggedInUser !== false) {
                    // Iniciar sesión
                    session_start();
                    $_SESSION["user"] = $loggedInUser;

                    // Redireccionar a la página principal u otra página deseada
                    header("Location: ../index.php");
                } else {
                    // Redireccionar al formulario de inicio de sesión con un mensaje de error
                    header("Location: ../views/login.php?info=error_invalid_credentials");
                    exit();
                }
            }
        }
    }

    public function logout()
    {
        session_start();
        $_SESSION = array();
        session_destroy();
        header("Location: ../index.php");
        exit();
    }
}
