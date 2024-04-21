<?php 
        // Title of the page
        isset($title) ? $title : $title = "CRUD";
        // Path to access assets folder from any file
        isset($dipath) ? $dipath : $dipath = "./";
?>

<head>
    <meta charset="UTF-8">
    <title><?php echo $title ?></title>
    <link rel="stylesheet" href="<?php echo $dipath . "assets/css/bootstrap.min.css" ?>">
    <script src="<?php echo $dipath . "assets/js/bootstrap.min.js" ?>"></script>
    <script src="https://kit.fontawesome.com/f008f6fb10.js" crossorigin="anonymous"></script>
</head>