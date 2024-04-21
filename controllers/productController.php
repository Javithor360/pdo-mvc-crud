<?php 

require_once("../models/productModel.php");

$controller = new ProductController();

if (isset($_POST['action']) || isset($_GET['action'])) {
    $action = $_POST['action'] ?? $_GET['action'];
    if (method_exists($controller, $action)) {
        $controller->$action();
    } else {
        echo "Error: No existe el método $action en el controlador";
    }
}

class ProductController {
    public static function getProducts() {
        $productModel = new Product(null, null, null, null, null, null);
        return $productModel->fetchProducts();
    }

    public function insert() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (
                empty($_POST["name"]) ||
                empty($_POST["description"]) ||
                empty($_POST["owner"])
            ) {
                header("Location: ../views/products.php?info=error_empty_fields");
                exit();
            } else {
                $name = $_POST["name"];
                $description = $_POST["description"];
                $owner = $_POST["owner"];
                $product = new Product(null, $owner, $name, $description, null);
                if ($product->saveProduct() === true) {
                    header("Location: ../views/products.php?info=success_insert");
                } else {
                    header("Location: ../views/products.php?info=error_insert");
                }
                exit();
            }
        }
    }

    public function update() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (
                empty($_POST["name"]) ||
                empty($_POST["description"]) ||
                empty($_POST["id"]) ||
                empty($_POST["owner"])
            ) {
                header("Location: ../views/products.php?info=error_empty_fields");
                exit();
            } else {
                $id = $_POST["id"];
                $name = $_POST["name"];
                $description = $_POST["description"];
                $owner = $_POST["owner"];
                $product = new Product($id, $owner, $name, $description, null);
                if ($product->editProductInfo() === true) {
                    header("Location: ../views/products.php?info=success_update");
                } else {
                    header("Location: ../views/products.php?info=error_update");
                }
                exit();
            }
        }
    }

    public function delete() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (empty($_POST["id"])) {
                header("Location: ../views/products.php?info=error_empty_fields");
                exit();
            } else {
                $id = $_POST["id"];
                $product = new Product($id, null, null, null, null);
                if ($product->deleteProductFromId() === true) {
                    header("Location: ../views/products.php?info=success_delete");
                } else {
                    header("Location: ../views/products.php?info=error_delete");
                }
                exit();
            }
        }
    }
}