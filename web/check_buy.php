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
    
    if(isset($_POST["index-id"]) && isset($_POST["index-cantidad"])){
        // Se actualiza el carrito
        foreach($_SESSION["cart"] as $key => $producto){
            $_SESSION["cart"][$key]["cantidad"] = $_POST["index-cantidad"][$key];
        }

        // Si se pulsó el botón actualizar, se devuelve al index
        if(isset($_POST["actualizar"])){
            echo "<script>window.location.href='index.php?cart=24';</script>";
        }

        // A partir de aquí, se supone que es para seguir con el proceso de finalizar la compra        
        $importe_total = 0;
        // Si el usuario está logueado, actualizar el carrito (actualizar precios y ofertas por lo que pueda pasar)
            // Esta parte solo la hago en la confirmación, ya que se va a hacer menos que la actualización del carrito, pero es crucial en este punto.
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
        // Si todo ha ido bien y se ha llegado hasta aquí, se recuperan los datos de dirección si hubiese para mostrarlos
        $direccion = UserModel::getDireccion($_SESSION["username"]);


    }else{
        // Si no cumple ninguna condición para modificar el carro o confirmar la compra, devolvemos al usuario al index
        echo "<script>window.location.href='index.php';</script>";
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
    <h3>Confirmación de compra</h3>
</div>


<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <form action="end_buying.php" method="POST">
                <h4 class="text-success text-center" id="cartAdd"></h4>
                <?php 
                    $total = 0;
                    foreach($_SESSION["cart"] as $key => $producto){
        
                        // Va a almacenar el total de los productos y el precio total de este producto
                        $totalProducto = ($producto["precioFinal"] * $producto["cantidad"]);
                        $total += $totalProducto;
                
                ?>
                    <div class="mb-5 row col-12">
                        <div class="col-4 col-lg-2">
                            <img width="125" style="display: inline;" src=<?php echo $producto["imagen"] ?> class="img-fluid producto-imagen">
                        </div>
                        <!-- Nombre, cantidad y precio -->
                        <div class="row col-8 col-lg-10">
                            <!-- Nombre -->
                            <h4 class="col-12"><?php echo $producto["nombre"] ?></h4>
                            <!-- cantidad -->
                            <div class="text-left row col-lg-6 col-12">
                                <h6 class="col-12">Cantidad: <?php echo $producto["cantidad"] ?></h6>
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
                <button type="submit" name="confirmar" class="btn btn-primary float-right">Confirmar pedido</button>
            </form>
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