<?php
    require_once("user_model.php");

    // Se comprueba que se está recibiendo algo con GET
    if(isset($_GET["id"])){
        $id = $_GET["id"];
    }else{
        header("Location:user_panel.php");
    }


    session_start();
    // Comprobar que el usuario es el que tiene los permisos para ver la factura
    $factura = UserModel::getFacturaConcreta($_SESSION["username"], $id);

    // Si la factura pertenece al usuario se devuelve un objeto. En caso contrario devuelve null, así que si ha devuelto null, redirigimos al usuario
    if($factura == null){
        echo "<script>window.location.href='user_panel.php';</script>";
    }else{
        // Si el usuario tiene permisos, se almacena la factura en una sesion
        $_SESSION["factura"] = $factura;
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

<!-- Jumbotron que muestra donde está el amdinistrador -->
<div class="jumbotron text-center">
    <h1>Latiende Sita</h1>
    <h3>Vista en detalle de factura #<?php echo $factura["id_factura"]; ?></h3>
</div>

<div class="container-fluid">
    <div class="row col-12 text-center">

        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">#Producto</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Cantidad</th>
                    <th scope="col">Precio</th>
                    <th scope="col">Oferta</th>
                    <th scope="col">Precio final</th>
                    <th scope="col">Total</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    // Se decodifica la parte del carro de la factura (estaba en JSON)
                    $carro = json_decode($factura["carro"], true);
                    foreach($carro as $key => $producto){ ?>
                    <tr>
                        <td><?php echo $producto['id']?></td>
                        <td><?php echo $producto['nombre']?></td>
                        <td><?php echo $producto['cantidad']?></td>
                        <td><?php echo $producto['precio']?>€</td>
                        <td>-<?php echo $producto['oferta']?>%</td>
                        <td><?php echo $producto['precioFinal']?>€</td>
                        <td class="text-danger"><strong><?php echo ($producto['precioFinal'] * $producto['cantidad']); ?>€</strong></td>
                        
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <h4 class="col-12 mx-auto">TOTAL: <?php echo $factura["importe_total"] ?>€</h4>
        <hr>
        <form action="print_factura.php" method="POST">
            <input type="hidden" name="factura-id" value="<?php echo $id?>">
            <button type="submit" name="imprimir" class="col-12 ml-2 btn btn-danger">Imprimir factura en PDF</button>
        </form>
    </div>
</div>



<!-- Opciones de navegación extras ( en la barra de navegación ya están, pero por dar mas apoyo visual) -->
<div class="container-fluid">
    <div class="row">
        <a class="col-12 ml-2 mt-4 text-primary" href="index.php">Volver al inicio</a>
        <a class="col-12 ml-2 mt-4 text-primary" href="user_panel.php">Volver al Panel de usuario</a>
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