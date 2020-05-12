<?php 
    require_once("user_model.php");
    require_once("product.php");
    require_once("product_model.php");


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
            // Si el usuario está logueado, actualizar el carrito (actualizar precios y ofertas por lo que pueda pasar)
            foreach($_SESSION["cart"] as $key => $producto_carrito){
                // Pedir los datos del producto 
                // Petición a product_model para obtener los datos del producto
                $productoJSON = ProductModel::getSimpleProduct($producto_carrito["id"]);
                if($productoJSON != null){
                    // Se decodifica el JSON obtenido
                    $productoJSON = json_decode($productoJSON, true);
                    $producto = new Product($productoJSON[0]["nombre"], $productoJSON[0]["id"], $productoJSON[0]["precio"], $productoJSON[0]["oferta"], $productoJSON[0]["imagen"]);

                    // Hay que modificar la sesion para sobreescribir los datos y actualizarlos
                    $_SESSION["cart"][$key] = array('id' => $producto->getId(), 'nombre' => $producto->getNombre(), 'cantidad' => $producto_carrito["cantidad"], 'imagen' => $producto->getImagen(), 
                        'precioFinal' => $producto->getPrecioFinal(), 'precio' => $producto->getPrecio(), 'oferta' => $producto->getOferta());
                }else{
                    // Si devuelve null, es que no ha encontrado el id, por tanto se vuelve al index
                    //echo "<script>window.location.href='index.php';</script>";
                    echo "algo ha ido mal";
                }
                
            }
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