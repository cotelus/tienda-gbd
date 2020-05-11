<?php
    // las variables superglobales de sesion deben usarse antes de enviar las cabeceras de la página

    session_start();

    // Compruebo si existe el usuario, y si existe lo igualo a la sesion
    if(isset($_SESSION["username"])){
        $username = $_SESSION["username"];
    }

    // Compruebo si existe el carrito y si existe lo igualo a la sesión
    if(!isset($_SESSION["cart"])){
        $_SESSION["cart"] = array();
    }

    // Hago los includes necesarios
    include 'product_model.php';
    $productList = array();
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

<!-- Esto son una serie de funciones que cargan o no en funcion de lo que se reciba por GET.
    Son para manejar el error en el login y registro -->
<?php
    if(isset($_GET["login"]) && $_GET["login"] == 1){
    ?>
        <script type="text/javascript">
            $(window).on('load',function(){
                $('#modalLoginForm').modal('show');
                $('#loginPlease').append( "Cuenta creada correctamente. Inicie sesión." );
            });
        </script>
    <?php
    }
?>
<!-- 
    Solo comprueba si ha recibido un parámetro por GET para cambiar una parte de la vista (que el carrito ponga "producto añadido")
-->
<?php
    if(isset($_GET["cart"])){
        if(count($_SESSION["cart"]) > 0){
            if( $_GET["cart"] == 23){
    ?>
                <script type="text/javascript">
                    $(window).on('load',function(){
                        $('#carritoForm').modal('show');
                        $('#cartAdd').append( "Nuevos productos añadidos" );
                    });
                </script>
    <?php
            }elseif($_GET["cart"] == 24){
            ?>
                <script type="text/javascript">
                        $(window).on('load',function(){
                            $('#carritoForm').modal('show');
                            $('#cartAdd').append( "Carrito actualizado" );
                        });
                </script>
    <?php
            }
        }
    }
?>
<!-- 
    comprueba si se viene de hacer un login mal
-->
<?php
    if(isset($_GET["wrongLogin"]) && $_GET["wrongLogin"] == 1){
    ?>
        <script type="text/javascript">
            $(window).on('load',function(){
                $('#modalLoginForm').modal('show');
                $('#loginError').append( "Credenciales incorrectos" );
            });
        </script>
    <?php
    }
?>
<?php
    // Si wrongRegister = 1, contraseña repetida no es igual
    // Si wrongRegister = 2, usuario duplicado
    if(isset($_GET["wrongRegister"]) && ($_GET["wrongRegister"] == 1 || $_GET["wrongRegister"] == 2) ){
        if($_GET["wrongRegister"] == 1){
            ?>
                <script type="text/javascript">
                    $(window).on('load',function(){
                        $('#modalRegisterForm').modal('show');
                        $('#signupError').append( "Las contraseñas no coinciden" );
                    });
                </script>
            <?php
        }
        else if($_GET["wrongRegister"] == 2){
            ?>
                <script type="text/javascript">
                    $(window).on('load',function(){
                        $('#modalRegisterForm').modal('show');
                        $('#signupError').append( "El usuario ya existe. Pruebe otro." );
                    });
                </script>
            <?php
        }
    }
    
?>


    <!-- Navbar -->
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
                <!-- No habrá catálogo en esta versión 
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Catálogo
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="#">Populares</a>
                        <a class="dropdown-item" href="#">Mostrar todo</a>
                    </div>
                </li>
                -->
                <!-- No habrá pagina de contacto en esta versión 
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Contacta
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="#">La empresa</a>
                        <a class="dropdown-item" href="#">Trabaja con nosotros</a>
                    </div>
                </li>
                -->
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

    <div class="jumbotron text-center">
        <h1>Latiende Sita</h1>
        <h3>Tu comercio local, ahora tambien online</h3>
        

        <!-- Botón de depuración temporal -> es para cerrar la sesión y resetear el carrito -->
        <div class="row text-center" >
            <div class="col-12">
                <a type="button" class="ml-2 btn btn-danger" href="close_session.php">Cerrar sesión</a>
                <br>
            </div>
        </div>

    </div>

    <!-- Contenido principal del INDEX - productos -->
    <div class="container-fluid">
        <div class="row">
            <!-- Producto individual -->
            <?php
                $productList=ProductModel::getProductList();
                foreach ($productList as $product){
            ?>
                <div class="mb-3 col-12 col-md-6 col-lg-3">
                    <div class="card">
                        <!-- marcador de oferta -->
                        <?php if($product[4] != 0){ ?>
                            <div class="align-middle position-absolute">
                                <h3 class="bg-danger text-light">OFERTA  -<?php echo $product[4]; ?>%</h3>
                            </div>
                        <?php } ?>
                        <!-- imagen -->
                        <img src=<?php echo $product[2]?>>
                        <form action='add_product.php' method='post' class="card-body">
                            <!-- Nombre -->
                            <h4><?php echo $product[1]?></h4>
                            <!-- ID (oculto) -->
                            <input type="hidden" name="id" value="<?php echo $product[0]?>">
                            <!-- Precio y oferta -->
                            <h5 class="card-title"><?php 
                                if($product[4] == 0){
                                    echo $product[3];
                                    echo "€";
                                }else{
                                    echo "<span style='text-decoration:line-through;'>";
                                    echo $product[3];
                                    echo "€</span>";
                                    echo "<span class='text-danger'> ";
                                    // Hago round para que redondée a 2 decimales máximo
                                    $valorOferta = round(($product[3] * ((100 - $product[4])/100)), 2);
                                    echo $valorOferta;
                                    echo "€</span>";
                                }
                            ?></h5>
                            <!-- Botón de configuración ( solo visible para administradores ) -->
                            <?php 
                                if ( isset($_SESSION["admin"]) && $_SESSION["admin"] === 1){
                                    echo "<a href='adminProduct.php?id=$product[0]' class='float-right text-secondary'><i class='fas fa-cog'></i></a>";
                                }
                            ?>
                            <button type="submit" class="btn btn-primary" >Agregar al carrito</button>
                        </form>  
                    </div>
                </div>
            <?php } ?>

        </div>
    </div>

    <!-- Modales -->
    <div class="container-fluid">
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
                                            <h6 class="col-6">Precio: </h6><h6 class="col-6"> <?php echo $producto["precioFinal"] ?> </h6>
                                            <h6 class="col-6">Total (<?php echo $producto["cantidad"] ?>): </h6><h6 class="col-6"> <?php echo $totalProducto ?> </h6>
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



        <!-- modal de login -->
        <div class="modal fade" id="modalLoginForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header text-center bg-primary text-light">
                        <h4 class="modal-title w-100 font-weight-bold">Login</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body mx-3">
                        <form action="comprueba_login.php" method="POST">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Usuario</label>
                                <input type="text" class="form-control" id="exampleInputEmail1" name="username" aria-describedby="emailHelp" placeholder="Introduzca su usuario" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Contraseña</label>
                                <input type="password" class="form-control" id="exampleInputPassword1" name="password" placeholder="Introduzca su contraseña" required>
                            </div>
                            <h4 class="text-danger" id="loginError"></h4>
                            <h4 class="text-success" id="loginPlease"></h4>
                            <button type="submit" class="btn btn-primary float-right">Enviar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        

        <!-- Modal de registro -->
        <div class="modal fade" id="modalRegisterForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header text-center bg-primary text-light">
                        <h4 class="modal-title w-100 font-weight-bold">Registro</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body mx-3">
                        <form action="comprueba_registro.php" method="POST">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Usuario</label>
                                <input type="text" class="form-control" id="exampleInputUsername" name="username" aria-describedby="emailHelp" placeholder="Introduzca su usuario" required>
                            </div>
                            <div class="form-group">
                            <label for="exampleInputPassword1">Contraseña</label>
                            <input type="password" class="form-control" id="exampleInputPassword1" name="password" placeholder="Introduzca su contraseña" required>
                            </div>
                            <div class="form-group">
                            <label for="exampleInputPassword1">Confirmar contraseña</label>
                            <input type="password" class="form-control" id="exampleInputPassword2" name="passwordConfirmada" placeholder="Repita su contraseña" required>
                            </div>
                            <h4 class="text-danger" id="signupError"></h4>
                            <button type="submit" class="btn btn-primary float-right">Enviar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- FOOTER -->
    <footer class="container-fluid page-footer font-small blue">
        <div class="row bg-secondary">
            <div class="col-12 py-5">
                <div class="mb-2 text-center">
                    <!-- Facebook -->
                    <a class="fb-ic" href="https://www.facebook.com">
                        <i class="fab fa-facebook-f fa-lg white-text mr-md-5 mr-3 fa-2x"> </i>
                    </a>
                    <!-- Twitter -->
                    <a class="tw-ic" href="https://www.twitter.com">
                        <i class="fab fa-twitter fa-lg white-text mr-md-5 mr-3 fa-2x"> </i>
                    </a>
                    <!-- Google +-->
                    <a class="gplus-ic" href="https://www.google.com">
                        <i class="fab fa-google-plus-g fa-lg white-text mr-md-5 mr-3 fa-2x"> </i>
                    </a>
                    <!--Linkedin -->
                    <a class="li-ic"  href="https://www.linkedin.com">
                        <i class="fab fa-linkedin-in fa-lg white-text mr-md-5 mr-3 fa-2x"> </i>
                    </a>
                    <!--Instagram-->
                    <a class="ins-ic"  href="https://www.instagram.com">
                        <i class="fab fa-instagram fa-lg white-text mr-md-5 mr-3 fa-2x"> </i>
                    </a>
                    <!--Pinterest-->
                    <a class="pin-ic"  href="https://www.pinterest.com">
                        <i class="fab fa-pinterest fa-lg white-text fa-2x"> </i>
                    </a>
                </div>
            </div>
            <div class="col-12 footer-copyright text-center bg-dark py-3 text-light">© 2020 Copyright:
                <a href="https://www.cotelo.es" class="text-secundario">Luis Cotelo</a>
            </div>
        </div>
    </footer>




</body>
</html>