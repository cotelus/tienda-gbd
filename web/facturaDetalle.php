<?php
    require_once("user_model.php");

    // Se comprueba que se está recibiendo algo con GET
    if(isset($_GET["id"])){
        $id = $_GET["id"];
    }else{
        header("Location:index.php?wrongLogin=1");
    }


    session_start();
    // Comprobar que el usuario es el que tiene los permisos para ver la factura
    $factura = UserModel::getFacturaConcreta($_SESSION["username"], $id);

    // Si la factura pertenece al usuario se devuelve un objeto. En caso contrario devuelve null, así que si ha devuelto null, redirigimos al usuario
    if($factura == null){
        echo "<script>window.location.href='user_panel.php';</script>";
    }

?>