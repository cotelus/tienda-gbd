<?php
// Cada vez que se añade un producto se redirige a esta página intermedia que lo añade al carrito.
// Cuando se han hecho las operaciones pertinentes, se vuelve al index.
    // Para no recargar la página, odría usarse AJAX o algún otro lenguaje de llamadas asíncronas.

require_once('product_model.php');
require_once('product.php');

// Esta función me va a servir para recorrer el array y buscar el índice que quiero a partir del id
function searchForId($id, $array) {
    foreach ($array as $key => $val) {
        if ($val['id'] == $id) {
            return $key;
        }
    }
    return null;
 }


 session_start();


// Se comprueba si se quiere eliminar algún elemento del carrito 
 //En caso afirmativo, busca el indice del elemento a borrar y lo elimina
if (isset($_GET['remove'])) {
    echo "aqui llego";
    if(is_numeric($_GET['remove'])){
        $remove = $_GET['remove'];
        $index = searchForId($remove, $_SESSION["cart"]);
        // la comparación es !== porque si devuelve el índice 0, da error
        if($index !== null && is_numeric($index)){
            echo "aqui si";
            // Elimino el valor en la posición $index
            unset($_SESSION["cart"][$index]);
            // Reordeno el array
            $_SESSION["cart"] = array_values($_SESSION["cart"]);
            // Vuelvo al index
            echo "<script>window.location.href='index.php?cart=24';</script>";
        }else{
            echo "<script>window.location.href='index.php';</script>";
        }
    }
}


// Se comprueba que existe el id del producto seleccionado, y si no existe se vuelve al index
if (isset($_POST['id'])) {
    $id = $_POST['id'];

    if(!isset($_SESSION["cart"])){
        $_SESSION["cart"] = array();
    }

    // Como count($_SESSION["cart"]) devuelve el tamaño en valor absoluto, puedo igualarlo para almacenar 
    $tamano = count($_SESSION["cart"]);
    // Si el producto ya estaba añadido al carrito, se le suma en 1 la cantidad.
    $cantidad = 1;
    // Hay que recorrer el array porque es multidimensional y no hay una función específica de php que obtenga el valor
        // Aprovechando que vamos a recorrer el array, vamos a optimizar un poco y a pedir a la BBDD solo los productos necesarios
    $yaEstaba = false;
    foreach($_SESSION["cart"] as $key => $producto){
        $tempId = $producto["id"];
        if($tempId == $id){
            // Se suma uno a la cantidad original, pero teniendo máximo 15
            if($producto["cantidad"] < 15){
                $cantidad = $producto["cantidad"] + 1;
            }else{
                $cantidad = 15;
            }
            // Se cambia también el tamaño para que realmente no sea tamaño, sino la posición
            $tamano = $key;
            // $yaEstaba se cambia a true y se ahorra la petición a la BBDD de sus componentes luego
            $yaEstaba = true;
        }
    }

    // Si el producto ya estaba en el carrito, solo se aumenta su cantidad, no se vuelve a realizar la petición
    if(!$yaEstaba){
        // Petición a product_model para obtener los datos del producto
        $productoJSON = ProductModel::getSimpleProduct($id);
        if($productoJSON != null){
            // Se decodifica el JSON obtenido
            $productoJSON = json_decode($productoJSON, true);
            $producto = new Product($productoJSON[0]["nombre"], $productoJSON[0]["id"], $productoJSON[0]["precio"], $productoJSON[0]["oferta"], $productoJSON[0]["imagen"]);

            // Hay que modificar la sesion para que muestre los datos mejor
            $_SESSION["cart"][$tamano] = array('id' => $producto->getId(), 'nombre' => $producto->getNombre(), 'cantidad' => $cantidad, 'imagen' => $producto->getImagen(), 
                'precioFinal' => $producto->getPrecioFinal(), 'precio' => $producto->getPrecio(), 'oferta' => $producto->getOferta());
        }else{
            // Si devuelve null, es que no ha encontrado el id, por tanto se vuelve al index
            echo "<script>window.location.href='index.php';</script>";
        }
    }else{
        $_SESSION["cart"][$tamano]['cantidad'] = $cantidad;
    }
    // Cuando se han terminado los cálculos, vuelvo al index. ( en este caso muestro el carrito también, pero puede cambiarse )
    echo "<script>window.location.href='index.php?cart=23';</script>";

}else{
    echo "<script>window.location.href='index.php';</script>";
}
?>