<?php
    require_once("user_model.php");


    session_start();
    // Si el usuario no debiera estar aquí, se le redirige
    if(!isset($_POST["confirmar"], $_SESSION["username"])){
        echo "<script>window.location.href='user_panel.php';</script>";
    }

    // Se codifica $_SESSION["cart"] en formato JSON
    $myJSON = json_encode($_SESSION["cart"]);
    // Se comprueba otra vez que el carrito no esté vacío, por lo que pueda pasar
    if(count($_SESSION["cart"]) > 0){
        // Se envia a user_model para que introduzca los datos en la BBDD
        $resultado = UserModel::crearFactura($_SESSION["username"], $myJSON, $_SESSION["importe_total"]);
    }else{
        echo "<script>window.location.href='user_panel.php';</script>";
    }

    // Se elimina el carrito
    unset($_SESSION["cart"]);
    // Se crea de nuevo el carrito
    $_SESSION["cart"] = array();


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
                        if(isset($_SESSION["cart"]) && count($_SESSION["cart"]) != 0){
                            echo "(";
                            echo count($_SESSION["cart"]);
                            echo ")"; 
                        }
                    ?>
                </a>
                <!-- Para personalizarlo aún mas, si el usuario ha iniciado sesión, no aparecerán los botones de login/registro, sino que se le saludará -->
                <?php
                    if(isset($_SESSION["username"])){
                        print "<a type='text' href='user_panel.php' class='my-2 my-sm-0'>Hola, " . $_SESSION["username"] . "</a>";
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

<!-- Jumbotron que muestra donde está el usuario -->
<div class="jumbotron text-center">
    <h1>Latiende Sita</h1>
    <h2> Bienvenido <?php print $_SESSION['username']; ?></h2>
    <h3 class="text-success">Pedido realizado con éxito</h3>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h5>Muchas gracias por su compra</h5>
            <p>Para mas información y/o descargar el recibo de compra, diríjase a la sección de usuarios</p>
            <a class="col-12 ml-2 mt-4 text-primary" href="user_panel.php">Volver al Panel de usuario</a>
        </div>
    </div>
</div>




<!-- modal del carrito -->
<div class="modal fade" id="carritoForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header text-center bg-primary text-light">
                    <h4 class="modal-title w-100 font-weight-bold">Carrito <i class="fas fa-shopping-cart"></i></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body mx-3">
                    <form action="check_buy.php" method="POST">
                        <h4 class="text-success text-center" id="cartAdd"></h4>
                        <?php 
                            $total = 0;
                            foreach($_SESSION["cart"] as $key => $producto){
                
                                // Va a almacenar el total de los productos y el precio total de este producto
                                $totalProducto = ($producto["precioFinal"] * $producto["cantidad"]);
                                $total += $totalProducto;
                        
                        ?>
                            <div class="mb-5 row col-12">
                                <!-- Imagen -->
                                <input type="hidden" name="index-id[<?php echo $key?>]" value="<?php echo $producto["id"]?>">
                                <div class="col-4 col-lg-2">
                                    <img width="125" style="display: inline;" src=<?php echo $producto["imagen"] ?> class="img-fluid producto-imagen">
                                </div>
                                <!-- Nombre, cantidad y precio -->
                                <div class="row col-8 col-lg-10">
                                    <h4 class="col-12"><?php echo $producto["nombre"] ?></h4>
                                    <!-- Cantidad 
                                    <div class="col-lg-6 col-12">
                                        <h6>Cantidad: <input type="number" id="producto-carro-<?php echo $producto["id"] ?>" value="<?php echo $producto["cantidad"] ?>" min="1" max="15" step="1"/></h6>
                                    </div> -->
                                    <div class="text-left row col-lg-6 col-12">
                                        <h6 class="col-12">Cantidad: <input type="number" id="producto-carro<?php echo $producto["id"] ?>" name="index-cantidad[<?php echo $key?>]" value="<?php echo $producto["cantidad"] ?>" min="1" max="15" step="1"/></h6>
                                        <a href="add_product.php?remove=<?php echo $producto["id"] ?>" class="col-12 text-danger">Eliminar</a>
                                    </div>
                                    <!-- Precio -->
                                    <div class="text-right row col-lg-6 col-12">
                                        <h6 class="col-6">Precio: </h6><h6 class="col-6"> <?php echo $producto["precioFinal"] ?> €</h6>
                                        <h6 class="col-6">Total (<?php echo $producto["cantidad"] ?>): </h6><h6 class="col-6"> <?php echo $totalProducto ?> €</h6>
                                    </div>
                                </div> 
                            </div>
                        <?php
                            } 
                        ?>
                        <div class="mb-5 row col-12">
                            <h5 class="col-6 text-right">Total: </h5><h5 class="col-6" id="total-carrito"> <?php echo $total?> €</h5>
                        </div>
                        <button type="submit" name="pagar" class="btn btn-primary float-right">Proceder al pago</button>
                        <button type="submit" name="actualizar" class="btn btn-warning float-right mr-3">Actualizar carrito</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


</body>
</html>