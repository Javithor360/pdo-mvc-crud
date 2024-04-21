<?php
session_start();

if(!isset($_SESSION["user"])) {
    header("Location: ./login.php?info=error_unauthorized");
    exit();
}

// Verificar si hay un mensaje de error en la URL
if (isset($_GET['info'])) {
    $info_type = $_GET['info'];
    if ($info_type === 'error_empty_fields') {
        $info_message = 'Todos los campos son obligatorios.';
    } else if($info_type === 'success_update') {
        $info_message = 'Usuario editado con éxito.';
    } else if($info_type === 'error_update') {
        $info_message = 'Ha ocurrido un error interno al editar el usuario.';
    } else if($info_type === 'success_delete') {
        $info_message = 'Usuario eliminado con éxito.';
    } else if($info_type === 'error_delete') {
        $info_message = 'Ha ocurrido un error interno al eliminar el usuario.';
    }
}

require_once("../controllers/userController.php");
$users = UserController::getUsers();
$focus = "Users";
$title = "Usuarios";
?>

<html lang="es">

<?php
    require_once("./components/head.php");
?>

<body>
    <?php require_once("./components/navbar.php"); ?>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <?php if (!empty($info_message)) : ?>
                <div class="alert mt-5 <?php echo (str_starts_with($info_type, "error") ? "alert-danger" : "alert-success") ?>"
                    role="alert">
                    <?php echo $info_message; ?>
                </div>
                <?php endif; ?>
                <div class="card mt-5">
                    <div class="card-header">
                        <h3 class="text-center">Usuarios Existentes</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped border text-center">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Usuario</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    if(count($users) > 0) {
                                        foreach($users as $user): 
                                ?>
                                <tr>
                                    <td><?= $user['id'] ?></td>
                                    <td><?= $user['name'] ?></td>
                                    <td><?= $user['username'] ?></td>
                                    <td class="d-flex gap-2 justify-content-center">
                                        <button class="btn btn-primary text-white p-2" data-bs-toggle="modal"
                                            data-bs-target="#editUserModal" onclick="loadUserInfo({
                                                            id: <?= $user['id'] ?>,
                                                            name: '<?= $user['name'] ?>',
                                                            username: '<?= $user['username'] ?>',
                                                            created_at: '<?= $user['created_at'] ?>'
                                                        })" <?php echo ($user['id'] === $_SESSION['user']['id'] ? "disabled" : "") ?> >
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>
                                        <button class="btn btn-danger text-white p-2" data-bs-toggle="modal"
                                            data-bs-target="#deleteUserModal" onclick="prepareId(<?= $user['id'] ?>)"
                                            <?php echo ($user['id'] === $_SESSION['user']['id'] ? "disabled" : "") ?> >
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <?php 
                                        endforeach; 
                                    } else {
                                ?>
                                <tr>
                                    <td colspan="4">No hay usuarios registrados.</td>
                                </tr>
                                <?php
                                    }
                                ?>
                            </tbody>
                        </table>
                        <a href="./register.php" class="btn btn-success">Agregar usuario</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal: Editar usuario -->
    <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editUserModalLabel">Editar Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="editUserModalBody">
                    <!-- Formulario de edición de usuario -->
                </div>
            </div>
        </div>
    </div>

    <!-- Modal: Eliminar usuario -->
    <div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteUserModalLabel">Eliminar usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="deleteUserModalBody">
                    <!-- Formulario de eliminación de usuario -->
                </div>
            </div>
        </div>
    </div>

</body>

<script>
function loadUserInfo(user) {
    document.getElementById("editUserModalBody").innerHTML =
        "<form action='../controllers/userController.php' method='post'>" +
        "<div class='form-group mb-4'>" +
        "<label for='id'><strong>ID</strong></label>" +
        "<input type='text' class='form-control' id='id' name='id' value='" + user.id + "' disabled>" +
        "</div>" +
        "<div class='form-group mb-4'>" +
        "<label for='name'><strong>Nombre</strong></label>" +
        "<input type='text' class='form-control' id='name' name='name' value='" + user.name + "'>" +
        "</div>" +
        "<div class='form-group mb-4'>" +
        "<label for='username'><strong>Usuario</strong></label>" +
        "<input type='text' class='form-control' id='username' name='username' value='" + user.username + "'>" +
        "</div>" +
        "<div class='form-group mb-4'>" +
        "<label for='created_at'><strong>Fecha de creación</strong></label>" +
        "<input type='text' class='form-control' id='created_at' name='created_at' value='" + new Date(user.created_at)
        .toJSON().slice(0, 10).split('-').reverse().join('/') + "' disabled>" +
        "</div>" +
        "<div class='d-flex justify-content-center gap-2'>" +
        "<button type='submit' class='btn btn-success mr-2'>Guardar cambios</button>" +
        "<button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancelar</button>" +
        "<input type='hidden' name='id' value='" + user.id + "'>" +
        "<input type='hidden' name='action' value='update'>" +
        "</div>" +
        "</form>";
}

function prepareId(id) {
    document.getElementById("deleteUserModalBody").innerHTML =
        "<p>¿Estás seguro de que deseas eliminar este usuario?</p>" +
        "<form action='../controllers/userController.php' method='post'>" +
        "<div class='modal-footer'>" +
        "<div class='d-flex justify-content-center gap-2'>" +
        "<button type='submit' class='btn btn-danger mr-2'>Confirmar</button>" +
        "<button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancelar</button>" +
        "<input type='hidden' name='id' value='" + id + "'>" +
        "<input type='hidden' name='action' value='delete'>" +
        "</div>" +
        "</div>" +
        "</form>";
}
</script>

</html>