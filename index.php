<?php
session_start();

$title = "Inicio";
$dipath = "./views/";
$focus = "Homepage";
?>

<html lang="es">
<?php
require_once("./views/components/head.php");
?>

<body>
    <?php require_once("./views/components/navbar.php"); ?>

    <div class="container mt-5">
        <div class="row">
            <div class="title">
                <h1 class="mb-4 py-1 border-bottom ">
                    <?php 
                if (isset($_SESSION['user'])) {
                    echo "¡Bienvenido, " . $_SESSION['user']['name'] . "!";
                } else {
                    echo "¡Bienvenido!";
                }
                ?>
                </h1>
                <h4>¿Necesitas algo?</h4>
                <p>Lo tenemos todo listo para ti...</p>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Iniciar sesión</h5>
                        <p class="card-text">Accede con tu cuenta para utilizar los servicios</p>
                        <a href="./views/login.php" class="btn btn-primary">Accede aquí</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Registro de cuentas</h5>
                        <p class="card-text">Si aún no posees una cuenta, es el momento de iniciar</p>
                        <a href="./views/register.php" class="btn btn-primary">Registrarse ahora</a>

                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Gestión de usuarios</h5>
                        <p class="card-text">Revisa todas las operaciones disponibles para los usuarios</p>
                        <a href="./views/users.php" class="btn btn-primary">Abrir menú</a>
                    </div>
                </div>
            </div>  
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Gestión de productos</h5>
                        <p class="card-text">Revisa la lista de productos disponibles</p>
                        <a href="./views/products.php" class="btn btn-primary">Revisar productos</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>