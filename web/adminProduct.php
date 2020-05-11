<?php
// Hay que comprobar que es un usuario logeado el que intenta acceder al sistema y que tiene los permisos necesarios
if(isset($_GET["id"])){
    $id = $_GET["id"];
}

require_once('product_model.php');

$productoJSON = ProductModel::getSimpleProduct($id);
if($productoJSON != null){
    // Se decodifica el JSON obtenido
    $productoJSON = json_decode($productoJSON, true);
    // Se crea el objeto producto a través de la clase Product
    $producto = new Product($productoJSON[0]["nombre"], $productoJSON[0]["id"], $productoJSON[0]["precio"], $productoJSON[0]["oferta"], $productoJSON[0]["imagen"]);
}


session_start();

if(!isset($_SESSION["username"])){
    header("Location:index.php?wrongLogin=1");
}

if(!isset($_SESSION["admin"]) || $_SESSION["admin"]!== 1){
    header("Location:index.php");
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
</div>



<div class="container-fluid">
    <div class="mx-auto row text-left" >
    <div class="col-12">
        <form action='administrar_libro.php' method='post'>
            <div class='form-group'>
                <input type='hidden' name='actualizar' value='actualizar'>
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
            <button type='submit' class='btn btn-primary btn-lg btn-block' value='Guardar'>Guardar</button>
        </form>
    </div>
</div>


</body>
</html>