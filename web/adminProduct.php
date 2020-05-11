<?php
require_once('product_model.php');
require_once('product.php');

// Lo primero va a ser comprobar que es usuario y tiene privilegios, para echarlo de la página si no es asi
session_start();

if(!isset($_SESSION["username"])){
    header("Location:index.php?wrongLogin=1");
}

if(!isset($_SESSION["admin"]) || $_SESSION["admin"]!== 1){
    header("Location:index.php");
}


// Se comprueba si se recibe un id en $_GET para mostrar
    // Lo paso por GET ya que es mas sencillo y no es un dato sensible
if(isset($_GET["id"]) && !isset($_POST["actualizar"])){
    $id = $_GET["id"];
    // Recupero el producto que sea y lo almaceno para mostrarlo mas tarde
    $productoJSON = ProductModel::getSimpleProduct($id);
    if($productoJSON != null){
        // Se decodifica el JSON obtenido
        $productoJSON = json_decode($productoJSON, true);
        // Se crea el objeto producto a través de la clase Product
        $producto = new Product($productoJSON[0]["nombre"], $productoJSON[0]["id"], $productoJSON[0]["precio"], $productoJSON[0]["oferta"], $productoJSON[0]["imagen"]);
    }
}

// Ahora comprueba si se está llegando a esta página tras una actualización de un producto
if(isset($_POST['actualizar'])){
    // Compruebo que las variables que tienen que llegar por POST existen
    if(isset($_POST["id"], $_POST["nombre"], $_POST["precio"], $_POST["oferta"], $_POST["imagen"] ) ){
        $id = $_POST["id"];
        $nombre = $_POST["nombre"];
        $precio = $_POST["precio"];
        $oferta = $_POST["oferta"];
        $imagen = $_POST["imagen"];

        // Comprobaciones sobre el producto{}
        $producto = new Product($nombre, $id, $precio, $oferta, $imagen);
        $productoModificado = true;
        ProductModel::modificaProducto($producto);
    }
}

// Ahora comprueba si se está llegando a esta página tras añadir un nuevo producto
if(isset($_POST['nuevo'])){
    // Compruebo que las variables que tienen que llegar por POST existen
    if(isset($_POST["nombre"], $_POST["precio"], $_POST["oferta"], $_POST["imagen"] ) ){
        $nombre = $_POST["nombre"];
        $precio = $_POST["precio"];
        $oferta = $_POST["oferta"];
        $imagen = $_POST["imagen"];

        // Comprobaciones sobre el producto{}
        //$productoModificado = new Product($nombre, $id, $precio, $oferta, $imagen);
        $producto = new Product($nombre, $id, $precio, $oferta, $imagen);
        $productoNuevo = true;
        ProductModel::modificaProducto($producto);
    }

}

// Ahora comprueba si se está llegando a esta página para eliminar un producto
if(isset($_POST['eliminar'])){
    // Compruebo que las variables que tienen que llegar por POST existen
    if(isset($_POST["id"], $_POST["nombre"], $_POST["precio"], $_POST["oferta"], $_POST["imagen"] ) ){
        // Se le pide al modelo que elimine el producto con id = $id 
        ProductModel::eliminarProducto($_POST["id"]);
    }
}


// Necesarias para la barra de navegación
    // Compruebo si existe el usuario, y si existe lo igualo a la sesion
    if(isset($_SESSION["username"])){
        $username = $_SESSION["username"];
    }

    // Compruebo si existe el carrito y si existe lo igualo a la sesión
    if(!isset($_SESSION["cart"])){
        $_SESSION["cart"] = array();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Latiende Sita</title>
  <link rel="shortcut icon" href="img/bs-icon.png" />
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="style/custom.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</head>


<body style="margin-top:3em;">

<nav class="navbar navbar-expand-lg fixed-top navbar-dark bg-dark">
    <a class="navbar-brand" href="index.php">
        <img src="img/bs-icon.png" width="60" height="60" alt="">
        Latiende Sita
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="index.php">Inicio <span class="sr-only">(current)</span></a>
            </li>
        </ul>
        <form class="form-inline my-2 my-lg-0">
            <div class="text-center">
                <!-- icono del carrito -->
                <a type='button' href='' class='mr-3 btn btn-primary my-2 my-sm-0' data-toggle='modal' data-target='#carritoForm'><i class="fas fa-shopping-cart"></i> Carrito
                    <?php 
                        if(count($_SESSION["cart"]) != 0){
                            echo "(";
                            echo count($_SESSION["cart"]);
                            echo ")"; 
                        }
                    ?>
                </a>
                <!-- Para personalizarlo aún mas, si el usuario ha iniciado sesión, no aparecerán los botones de login/registro, sino que se le saludará -->
                <?php
                    if(isset($username)){
                        print "<a type='text' href='user_panel.php' class='my-2 my-sm-0'>Hola, " . $username . "</a>";
                        if(isset($_SESSION["admin"]) && $_SESSION["admin"] == 1){
                            print "<a type='button' href='adminProduct.php' class='ml-3 my-2 my-sm-0 button btn btn-warning'>Administrar productos</a>";
                        }
                    }else{
                        print "<a type='button' href='' class='btn btn-primary my-2 my-sm-0' data-toggle='modal' data-target='#modalLoginForm'>Login</a>";
                        print "<a type='button' href='' class='btn btn-primary my-2 ml-1 my-sm-0' data-toggle='modal' data-target='#modalRegisterForm'>Registrarse</a>";
                    }
                ?>
            </div>
        </form>
    </div>
</nav>

<!-- Jumbotron que muestra donde está el amdinistrador -->
<div class="jumbotron text-center">
    <h1>Latiende Sita</h1>
    <h3>Página de administración de productos</h3>
    <?php 
        // Es solo para mostrar que se ha modificado un producto correctamente 
        if(isset($productoModificado)){
            echo "<h3 class='text-success'>Artículo modificado correctamente</h3>";
        }
    ?>
</div>


<?php 
    // Esta parte va a ser la administración de un producto en concreto. Si no existe tal producto, se muestra una vista para elegir qué hacer con los productos
    if(isset($producto)){
?>
        <div class="container-fluid">
            <div class="mx-auto row text-left" >
            <div class="col-12">
                <form action='adminProduct.php?id=<?php echo $id; ?>' method='post'>
                    <div class='form-group'>
                        <input type='hidden' name='id' value='<?php echo $producto->getId()?>'>
                    </div> 
                    <div class='form-group'>
                        <h4><label for='nombre' class='text-dark'>Nombre</label></h4>
                        <input type='text' name='nombre' class='form-control' value='<?php echo $producto->getNombre(); ?>'>
                    </div>
                    <div class='form-group'>
                        <h4><label for='precio' class='text-dark'>Precio</label></h4>
                        <input type='text' name='precio' class='form-control' value='<?php echo $producto->getPrecio(); ?>'>
                    </div>
                    <div class='form-group'>
                    <h4><label for='oferta' class='text-dark'>Oferta</label></h4>
                        <input type='text' name='oferta' class='form-control' value='<?php echo $producto->getOferta(); ?>'>
                    </div> 
                    <div class='form-group'>
                    <h4><label for='imagen' class='text-dark'>Imagen</label></h4>
                        <input type='text' name='imagen' class='form-control' value='<?php echo $producto->getImagen(); ?>'>
                    </div>
                    <button type="submit" name="actualizar" class="btn btn-warning col-12 mt-3">Actualizar producto</button>
                    <button type="submit" name="eliminar" class="btn btn-danger col-12 mt-3">Eliminar producto</button>
                </form>
            </div>
        </div>
<?php 
    }
    // Si no está definido el producto es que ni se ha llegado aquí tras actualizar ni hay un $_GET["id"], así que muestro las opciones de configuración que tiene el administrador
        // por una parte, un botón enorme para añadir un nuevo producto. Y por otra, muestro la lista de todos los productos
    elseif(isset($_POST["nuevoProducto"])){
        ?>
        <div class="container-fluid">
            <div class="mx-auto row text-left" >
            <div class="col-12">
                <form action='adminProduct.php' method='post'>
                    <div class='form-group'>
                        <h4><label for='nombre' class='text-dark'>Nombre</label></h4>
                        <input type='text' name='nombre' class='form-control' value='' required>
                    </div>
                    <div class='form-group'>
                        <h4><label for='precio' class='text-dark'>Precio</label></h4>
                        <input type='text' name='precio' class='form-control' value='' required>
                    </div>
                    <div class='form-group'>
                    <h4><label for='oferta' class='text-dark'>Oferta</label></h4>
                        <input type='text' name='oferta' class='form-control' value='' required>
                    </div> 
                    <div class='form-group'>
                    <h4><label for='imagen' class='text-dark'>Imagen</label></h4>
                        <input type='text' name='imagen' class='form-control' value='' required>
                    </div>
                    <button type="submit" name="nuevo" class="btn btn-success col-12 mt-3">Añadir producto</button>
                </form>
            </div>
        </div>


        <?php
    }
    elseif(isset($_POST["listarProductos"])){
        ?>
        <div class="container-fluid">
            <div class="mx-auto row text-left" >
            <div class="col-12">
                <table class="col-12 table">
                    <thead>
                        <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Precio</th>
                        <th scope="col">Oferta</th>
                        <th scope="col">Imagen</th>
                        <th scope="col">¿MODIFICAR?</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            // Le pido los datos de los produtos al modelo
                            $productList=ProductModel::getProductList();
                            // Itero sobre la lista para generar la vista
                            foreach ($productList as $product){
                            ?>
                                <tr>
                                    <th scope="row"><?php echo $product[0] ?></th>
                                    <td><?php echo $product[1] ?></td>
                                    <td><?php echo $product[3] ?></td>
                                    <td><?php echo $product[4] ?></td>
                                    <td><?php echo $product[2] ?></td>
                                    <td><a href="adminProduct.php?id=<?php echo $product[0] ?>"><button type="button" name="actualizar" class="btn btn-warning col-12">Modificar</button></a></td>
                                </tr>
                                <?php
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php
    }
    // Finalmente, si no hay nada que mostrar, muestro los dos botones, uno para modificar productos y otro para añadir nuevos
    else{
        ?>
        <div class="container-fluid">
            <div class="mx-auto row text-left" >
            <div class="col-12">
                <form action='adminProduct.php' method='post' class="col-12">
                    <button type="submit" name="nuevoProducto" class="btn btn-success col-12 mt-3 mb-3 btn-lg">Añadir nuevo producto</button>
                    <button type="submit" name="listarProductos" class="btn btn-primary col-12 mt-3 mb-3 btn-lg">Listar productos</button>
                </form>
            </div>
        </div>
        <?php
    }
?>

<!-- Opciones de navegación extras ( en la barra de navegación ya están, pero por dar mas apoyo visual) -->
<div class="container-fluid">
    <div class="row">
        <a class="col-12 ml-2 mt-4 text-primary" href="index.php">Volver al inicio</a>
        <a class="col-12 ml-2 mt-4 text-primary" href="adminProduct.php">Volver a administración de productos</a>
    </div>
</div>

</body>
</html>