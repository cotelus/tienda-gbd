<?php 
    // El array que se espera recibir con POST es de la siguiente forma:
        // {[idex]id - [index]cantidad]}, {[idex]id - [index]cantidad]}...
        // por tanto lo primero que voy a hacer es actualizar las cantidades por si no lo hubiera hecho correctamente el usuario
    // La posición iésima de cada array corresponde con un mismo id, cantidad y posición en el array $_SESSION["cart"]
    session_start();
    print_r($_POST["index-id"]);
    print_r($_POST["index-cantidad"]);

    array_values($_SESSION["cart"]);
    echo "<br>";
    print_r($_SESSION["cart"]);
    echo "<br>";
   
    if(isset($_POST["index-id"]) && isset($_POST["index-cantidad"])){
        foreach($_SESSION["cart"] as $key => $producto){
            echo $_POST["index-id"][$key];
            echo "-";
            echo $_POST["index-cantidad"][$key];
            echo "<br>";
            $_SESSION["cart"][$key]["cantidad"] = $_POST["index-cantidad"][$key];
        }


        // Vamos a hacerlo aquí mismitico
        // Solo se quiere almacenar la factura en la BBDD. Se hace a través del usuario
        
        // Comprobar que hay un usuario logueado
        if(isset($_SESSION["username"])){
            echo "hola";
        }else{
            echo "adios";
        }

        // Si el usuario está logueado, actualizar el carrito (actualizar precios y ofertas por lo que pueda pasar)(altamente opcional)

        // Mandas a user_model los datos para almacenar en la BBDD con el carrito en json_encode

        // Mostrar algo por pantalla
    }

    // Si se pulsó el botón actualizar, se devuelve al index
    if(isset($_POST["actualizar"])){
        echo "voy a actualizar <br>";
        // En el servidor esto no funciona por algún motivo
        //header("location:index.php?cart=24");
        echo "<script>window.location.href='index.php?cart=24';</script>";
    }
    

?>