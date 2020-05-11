<?php
// Hay que comprobar que es un usuario logeado el que intenta acceder al sistema y que tiene los permisos necesarios
if(isset($_GET["id"])){
    $id = $_GET["id"];
}


session_start();

if(!isset($_SESSION["username"])){
    header("Location:index.php?wrongLogin=1");
}

if(!isset($_SESSION["admin"]) || $_SESSION["admin"]!== 1){
    header("Location:index.php");
}




?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <title> Administrar Producto </title>
</head>

<body>


<div class="container-fluid">
    <div class="row text-center" >
    <div class="mb-3 col-12 col-md-6 col-lg-3">
        hola wacho
    </div>
</div>


</body>
</html>