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
    } else if($info_type === 'success_insert') {
        $info_message = 'Producto creado con éxito.';
    } else if($info_type === 'error_insert') {
        $info_message = 'Ha ocurrido un error interno al crear el producto.';
    } else if($info_type === 'success_delete') {
        $info_message = 'Usuario eliminado con éxito.';
    } else if($info_type === 'error_delete') {
        $info_message = 'Ha ocurrido un error interno al eliminar el usuario.';
    } else if($info_type === 'success_update') {
        $info_message = 'Usuario editado con éxito.';
    } else if($info_type === 'error_update') {
        $info_message = 'Ha ocurrido un error interno al editar el usuario.';
    }
}

require_once("../controllers/productController.php");
require_once("../controllers/userController.php");
$products = ProductController::getProducts();
$usernames = UserController::getAllUserNames();
$focus = "Products";
$title = "Productos";
?>

<html lang="es">

<?php 
    require_once("./components/head.php");
?>

<body>
    <?php require_once("./components/navbar.php") ?>

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
                        <h3 class="text-center">Productos Existentes</h3>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-striped border text-center">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Dueño</th>
                                    <th>Nombre</th>
                                    <th>Descripción</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody class="align-middle">
                                <?php 
                                if(count($products) > 0) {
                                    foreach($products as $product) :
                                ?>
                                <tr>
                                    <td><?= $product['id'] ?></td>
                                    <td>
                                        <?php 
                                            $ownerId = $product['product_owner'];
                                            if (isset($usernames[$ownerId])) {
                                                echo $usernames[$ownerId];
                                            } else {
                                                echo "Dueño no disponible";
                                            }
                                        ?>
                                    </td>
                                    <td><?= $product['name'] ?></td>
                                    <td><?= $product['description'] ?></td>
                                    <td class="justify-content-center">
                                        <button class="btn btn-primary mb-2" data-bs-toggle="modal"
                                            data-bs-target="#editProductModal" onclick="loadProductInfo({
                                            id: <?= $product['id'] ?>,
                                            name: '<?= $product['name'] ?>',
                                            description: '<?= $product['description'] ?>',
                                            owner: <?= $product['product_owner'] ?>,
                                            ownerName: '<?= $usernames[$product['product_owner']] ?>',
                                            created_at: '<?= $product['created_at'] ?>'
                                        })">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>
                                        <button class="btn btn-danger" data-bs-toggle="modal"
                                            data-bs-target="#deleteProductModal" onclick="prepareId(<?= $product['id'] ?>)">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <?php endforeach;
                                    } else {
                                ?>
                                <tr>
                                    <td colspan="5">No hay productos registrados.</td>
                                </tr>
                                <?php 
                                    }
                                ?>
                            </tbody>
                        </table>
                        <button type="button" class="btn btn-success" data-bs-toggle="modal"
                            data-bs-target="#newProductModal">Nuevo producto</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal: Nuevo producto -->
    <div class="modal fade" id="newProductModal" tabindex="-1" aria-labelledby="newProductModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="newProductModalLabel">Nuevo producto</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="newProductModalBody">
                    <form action="../controllers/productController.php" method="post">
                        <div class="form-group mb-4">
                            <label for="name">Nombre</label>
                            <input type="text" class="form-control" id="name" name="name"
                                placeholder="Nombre del producto" required>
                        </div>
                        <div class="form-group mb-4">
                            <label for="description">Descripción</label>
                            <textarea class="form-control" id="description" name="description"
                                placeholder="Descripción del producto" required></textarea>
                        </div>
                        <div class="form-group mb-lg-4">
                            <label for="owner">Dueño</label>
                            <select class="form-select" id="owner" name="owner" required>
                                <option value="" selected>Selecciona un dueño</option>
                                <?php 
                                foreach($usernames as $id => $name) {
                                ?>
                                <option value="<?= $id ?>"><?= $id . ". " . $name ?></option>;
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="d-flex justify-content-center gap-2 modal-footer">
                            <input type="hidden" name="action" value="insert" />
                            <button type="submit" class="btn btn-primary">Crear producto</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal: Editar producto -->
    <div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="editProductModalLabel">Editar producto</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="editProductModalBody">
                    <!-- Formulario de edición de producto -->
                </div>
            </div>
        </div>
    </div>

    <!-- Modal: Eliminar producto -->
    <div class="modal fade" id="deleteProductModal" tabindex="-1" aria-labelledby="deleteProductModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="deleteProductModalLabel">Eliminar producto</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="deleteProductModalBody">
                    <!-- Formulario de eliminación de producto -->
                </div>
            </div>
        </div>
    </div>
</body>

<script>
function loadProductInfo(product) {
        var ownerValue = product.owner; // Guardando el valor de product.owner en una variable
        var options = ""; // Variable para almacenar las opciones del select
        
        <?php foreach($usernames as $id => $name) : ?>
            // Si el ID actual coincide con el valor de product.owner, no añadirlo a las opciones
            if ("<?= $id ?>" != ownerValue) {
                // Concatena las opciones en la variable 'options'
                options += "<option value='<?= $id ?>'><?= $id . '. ' . $name ?></option>";
            }
        <?php endforeach; ?>
        
        // Agrega la opción del dueño actual al final de las opciones
        options += "<option value='" + product.owner + "' selected>" + product.owner + ". " + product.ownerName + "</option>";
        
        // Construye el formulario con las opciones del select
        var formHTML = `
            <form action='../controllers/productController.php' method='post'>
                <div class='form-group mb-4'>
                    <label for='id'><strong>ID</strong></label>
                    <input type='text' class='form-control' id='id' name='id' value='${product.id}' disabled>
                </div>
                <div class='form-group mb-4'>
                    <label for='name'><strong>Nombre</strong></label>
                    <input type='text' class='form-control' id='name' name='name' value='${product.name}'>
                </div>
                <div class='form-group mb-4'>
                    <label for='description'><strong>Descripción</strong></label>
                    <textarea class='form-control' id='description' name='description'>${product.description}</textarea>
                </div>
                <div class='form-group mb-4'>
                    <label for='owner'><strong>Dueño</strong></label>
                    <select class='form-select' id='owner' name='owner'>
                        ${options}
                    </select>
                </div>
                <div class='form-group mb-4'>
                    <label for='created_at'><strong>Fecha de creación</strong></label>
                    <input type='text' class='form-control' id='created_at' name='created_at' value='${product.created_at}' disabled>
                </div>
                <div class='d-flex justify-content-center gap-2'>
                    <input type='hidden' name='id' value='${product.id}' />
                    <input type='hidden' name='action' value='update' />
                    <button type='submit' class='btn btn-primary'>Actualizar producto</button>
                    <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Cancelar</button>
                </div>
            </form>`;
        
        // Actualiza el contenido del modal con el formulario construido
        document.getElementById("editProductModalBody").innerHTML = formHTML;
    }

function prepareId(id) {
    document.getElementById("deleteProductModalBody").innerHTML =
        "<p>¿Estás seguro de que deseas eliminar este producto?</p>" +
        "<form action='../controllers/productController.php' method='post'>" +
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