<?php
session_start();

if(isset($_SESSION["user"])) {
    header("Location: ./users.php");
    exit();
}

$title = "Inicio de sesión";
$focus = "Login";
$info_message = '';

// Verificar si hay un mensaje de error en la URL
if (isset($_GET['info'])) {
    $info_type = $_GET['info'];
    if ($info_type === 'error_invalid_credentials') {
        $info_message = 'Credenciales inválidas.';
    } else if ($info_type === 'error_empty_fields') {
        $info_message = 'Todos los campos son obligatorios.';
    } else if($info_type === 'success_register') {
        $info_message = 'Usuario creado con éxito.';
    } else if($info_type === 'error_unauthorized') {
        $info_message = 'No tienes permisos para acceder a esta página.';
    }
}
?>

<html lang="es">

<?php
require_once("./components/head.php");
?>

<body>
    <?php require_once("./components/navbar.php"); ?>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <?php if (!empty($info_message)) : ?>
                <div class="alert <?php echo (str_starts_with($info_type, "error") ? "alert-danger" : "alert-success") ?>" role="alert">
                    <?php echo $info_message; ?>
                </div>
                <?php endif; ?>
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-center">Bienvenido</h3>
                    </div>
                    <div class="card-body">
                        <form action="../controllers/authController.php" method="post" autocomplete="off">
                            <div class="form-group">
                                <label for="user">Usuario</label>
                                <input type="text" class="form-control" id="user"
                                    name="user" placeholder="Ingrese su usuario" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label for="password">Contraseña</label>
                                <input type="password" class="form-control" id="password" name="password"
                                    placeholder="Ingrese su contraseña" autocomplete="off">
                            </div>
                            <div class="d-flex gap-2 mt-3">
                                <input type="hidden" name="action" value="login" />
                                <input type="submit" value="Iniciar sesión" class="btn btn-primary btn-block" />
                                <a href="./register.php" class="btn btn-outline-primary btn-block">Registrarse</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>