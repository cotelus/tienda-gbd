<?php 
    // El array que se espera recibir con POST es de la siguiente forma:
        // {[idex]id - [index]cantidad]}, {[idex]id - [index]cantidad]}...
        // por tanto lo primero que voy a hacer es actualizar las cantidades por si no lo hubiera hecho correctamente el usuario
    // La posición iésima de cada array corresponde con un mismo id, cantidad y posición en el array $_SESSION["cart"]
    session_start();
    print_r($_POST["index-id"]);
    print_r($_POST["index-cantidad"]);
   
    if(isset($_POST["index-id"]) && isset($_POST["index-cantidad"])){
        for($i = 1; $i <= count($_SESSION["cart"]) ; $i++){
            echo $_POST["index-id"][$i];
            echo "-";
            echo $_POST["index-cantidad"][$i];
            echo "<br>";
            $_SESSION["cart"][$i]["cantidad"] = $_POST["index-cantidad"][$i];
        }
    }

    // Si se pulsó el botón actualizar, se devuelve al index
    if(isset($_POST["actualizar"])){
        echo "voy a actualizar <br>";
       header("location:index.php?cart=24");
    }
    //header("location:index.php?cart=23");
?>