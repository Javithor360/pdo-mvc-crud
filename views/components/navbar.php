<nav class="navbar navbar-dark bg-dark navbar-expand-sm">
    <div class="container-fluid">
        <div class="navbar-nav me-auto">
            <a class="<?php echo (isset($focus) && $focus == "Homepage") ? "nav-link active" : "nav-link"  ?>" href="<?php echo $dipath !== "./" ? "./index.php" : $dipath . "../index.php" ?>">Inicio</a>
            <a class="<?php echo (isset($focus) && $focus == "Users") ? "nav-link active" : "nav-link"  ?>" href="<?php echo $dipath . "users.php" ?>">Usuarios</a>
            <a class="<?php echo (isset($focus) && $focus == "Products") ? 'nav-link active' : "nav-link"  ?>" href="<?php echo $dipath . "products.php" ?>">Productos</a>
        </div>
        <div class="navbar-nav ms-auto">
            <a 
                class="<?php echo (isset($focus) && $focus == "Login") ? "nav-link active" : "nav-link"  ?>" 
                href="<?php echo isset($_SESSION['user']) ? ($dipath !== "./" ? "./controllers/authController.php?action=logout" : $dipath . "../controllers/authController.php?action=logout") : $dipath . "login.php" ?>"
            >
                <?php echo isset($_SESSION['user']) ? "Cerrar sesión" : "Iniciar sesión" ?>
            </a>
        </div>
    </div>
</nav>