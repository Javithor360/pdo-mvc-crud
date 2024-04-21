<?php
$title = "Registro";
$focus = "Login";
$error_message = '';

// Verificar si hay un mensaje de error en la URL
if (isset($_GET['error'])) {
    $error_type = $_GET['error'];
    if ($error_type === 'empty_fields') {
        $error_message = 'Todos los campos son obligatorios.';
    } else if ($error_type === 'password_mismatch') {
        $error_message = 'Las contraseñas no coinciden.';
    } else if ($error_type === 'register_error') {
        $error_message = 'Ha ocurrido un error interno al registrar el usuario.';
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
                <?php if (!empty($error_message)) : ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error_message; ?>
                    </div>
                <?php endif; ?>
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-center">Registro</h3>
                        <p class="text-sm text-center">Completa la información para crear un nuevo usuario</p>
                    </div>
                    <div class="card-body">
                        <form action="../controllers/authController.php" method="post" autocomplete="off">
                            <div class="form-group m-2">
                                <label for="name">Nombre completo</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Ingrese su usuario" autocomplete="off">
                            </div>
                            <div class="form-group m-2">
                                <label for="user">Usuario</label>
                                <input type="text" class="form-control" id="user" name="user" placeholder="Ingrese su usuario" autocomplete="off">
                            </div>
                            <div class="form-group m-2">
                                <label for="password">Contraseña</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Ingrese su contraseña" autocomplete="off">
                            </div>
                            <div class="form-group m-2">
                                <label for="r-password">Repetir contraseña</label>
                                <input type="password" class="form-control" id="r-password" name="r-password" placeholder="Repita la contraseña" autocomplete="off">
                            </div>
                            <div class="d-flex gap-2 mx-2 mt-3">
                                <input type="hidden" name="action" value="register" />
                                <button type="submit" class="btn btn-primary btn-block">Completar registro</button>
                                <a href="./login.php" class="btn btn-secondary btn-block">Iniciar sesión</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
