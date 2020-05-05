<?php
// Cada vez que se añade un producto se redirige a esta página intermedia que lo añade al carrito.
// Cuando se han hecho las operaciones pertinentes, se vuelve al index.
    // Para no recargar la página, odría usarse AJAX o algún otro lenguaje de llamadas asíncronas.

require('product_model.php');
//include('product.php');

// Se comprueba que existe el id del producto seleccionado
if (isset($_POST['id'])) {
    $id = $_POST['id'];
}

// Llamar a product_model para preguntar por el id del producto (devuelve null si no existe, en caso contrario devuelve un objeto de la clase producto )


            // Ahora mismo esto es prueba para comprobar que en el index se coge bien la información
            session_start();
            if(!isset($_SESSION["cart"])){
                $_SESSION["cart"] = array();
            }

            // 
            $nombre = "otro nombre";
            $tamano = count($_SESSION["cart"]) + 1;
            // Si el producto ya estaba añadido al carrito, se le suma en 1 la cantidad.
            $cantidad = 1;
            // Hay que recorrer el array porque es multidimensional y no hay una función específica de php que obtenga el valor
            foreach($_SESSION["cart"] as $key => $producto){
                //if ($producto['id'] == $id {
                    //$cantidad = $producto["cantidad"];
                    // Se cambia también el tamaño para que realmente no sea tamaño, sino la posición
                //}
                $tempId = $producto["id"];
                if($tempId == $id){
                    $cantidad = $producto["cantidad"] + 1;
                    $tamano = $key;
                }
            }
            $_SESSION["cart"][$tamano] = array('id' => $id, 'nombre' => $nombre, 'cantidad' => $cantidad);

// Si existe en la BBDD el producto con ID = X -> se inicia la sesión (start_session())

// Se añade el id(pero no se muestra), nombre, precio_final (precio - oferta), y cantidad a $_SESSION["cart"][][] 
    // Si el producto con mismo id ya estaba en el carrito, se le suma uno

// 







// Cuando se han terminado los cálculos, vuelvo al index. ( en este caso muestro el carrito también, pero puede cambiarse )
header("location:index.php?cart=23");
?>