<?php 
    require_once("user_model.php");
    require_once("product.php");
    require_once("product_model.php");


    // El array que se espera recibir con POST es de la siguiente forma:
        // {[idex]id - [index]cantidad]}, {[idex]id - [index]cantidad]}...
        // por tanto lo primero que voy a hacer es actualizar las cantidades por si no lo hubiera hecho correctamente el usuario
    // La posición iésima de cada array corresponde con un mismo id, cantidad y posición en el array $_SESSION["cart"]
    session_start();


    // Si el carrito está vacío se vuelve al index
    if(count($_SESSION["cart"]) < 1){
        echo "<script>window.location.href='index.php';</script>";
    }
    // Si no hay un usuario logueado, se le pide que inicie sesión
    if(!isset($_SESSION["username"])){
        echo "<script>window.location.href='index.php?wrongLogin=2';</script>";
    }


    print_r($_POST["index-id"]);
    print_r($_POST["index-cantidad"]);

    array_values($_SESSION["cart"]);
    echo "<br>";
    print_r($_SESSION["cart"]);
    echo "<br>";
   
    if(isset($_POST["index-id"]) && isset($_POST["index-cantidad"])){
        // Totalmente temporal
        foreach($_SESSION["cart"] as $key => $producto){
            echo $_POST["index-id"][$key];
            echo "-";
            echo $_POST["index-cantidad"][$key];
            echo "<br>";
            $_SESSION["cart"][$key]["cantidad"] = $_POST["index-cantidad"][$key];
        }

        // Hacerlo solo en la confirmación, ya que puede ser una tarea pesada para el servidor
        // Solo se quiere almacenar la factura en la BBDD. Se hace a través del usuario
        
        // Comprobar que hay un usuario logueado
        if(isset($_SESSION["username"])){
            $importe_total = 0;
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

                    // Se suma al total
                    $importe_total +=  $producto_carrito["cantidad"] * $producto->getPrecioFinal();
                    $_SESSION["importe_total"] = $importe_total;
                }else{
                    // Si devuelve null, es que no ha encontrado el id, por tanto se vuelve al index sin actualizar
                    echo "<script>window.location.href='index.php';</script>";
                }
            }
            
            echo "<br>";
            print_r ($_SESSION["cart"]);
            echo "<br>";
            $myJSON = json_encode($_SESSION["cart"]);
            echo "<br>";
            echo $myJSON;
            //$resultado = UserModel::crearFactura($_SESSION["username"], $myJSON, $_SESSION["importe_total"]);
            echo "<br>";
            //echo $resultado;

            echo "<br>";
            echo "<br>";
            // Ahora hay que recuperar una factura cualquiera y mostrarla
            $resultado = UserModel::getFacturaConcreta($_SESSION["username"], 6);
            print_r($resultado);
            // Se decodifica el carro de la factura en formato JSON
            echo "<br>";
            echo "<br>";
            $carroJSON = json_decode($resultado["carro"], true);
            print_r($carroJSON);
            // Ahora que se tiene el carro en JSON, hay que distinguir en productos individuales
            foreach($carroJSON as $key => $producto){
                echo "<br>";
                echo $producto['id'];
                echo $producto['precio'];
                echo $producto['oferta'];
                echo $producto['cantidad'];
                echo $producto['imagen'];
                echo $producto['precioFinal'];
                $total = $producto['precioFinal'] * $producto['cantidad'];
                echo $total;
                echo "<br>";
            }


        }else{
            echo "adios";
        }


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