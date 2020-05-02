<?php
    // las variables superglobales de sesion deben usarse antes de enviar las cabeceras de la página

    session_start();
    if(isset($_SESSION["username"])){
        $username = $_SESSION["username"];
    }

    // Hago los includes necesarios
    include 'product_model.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Tienda</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
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
<nav class="navbar navbar-expand-sm fixed-top navbar-dark bg-dark">
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
                <a class="nav-link" href="#">Inicio <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Nosotros</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Catálogo
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="#">Populares</a>
                    <a class="dropdown-item" href="#">Mostrar todo</a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Contacta
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="#">La empresa</a>
                    <a class="dropdown-item" href="#">Trabaja con nosotros</a>
                </div>
            </li>
        </ul>
        <form class="form-inline my-2 my-lg-0">
            <div class="text-center">
                <!-- icono del carrito -->
                <a type='button' href='carrito.php' class='btn btn-primary my-2 my-sm-0'>Carrito</a>
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
</div>

<!-- Contenido principal del INDEX - productos -->
<div class="container-fluid">
    <div class="row">
        <!-- Producto individual -->
        <?php
            $productList=ProductModel::getProductList();
        ?>
        <div class="col-3">
            <div class="card">
                <img src="data:image/jpeg;base64,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">
                <div class="card-body">
                    <span><?php echo $productList[0][2]?></span>
                    <h5 class="card-title">3€</h5>

                    <button class="btn btn-primary" >Agregar al carrito </button>
                </div>  
            </div>
        </div>
    </div>
</div>



<div class="container-fluid">
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

<!-- Espacio en blanco -->
<div style="height:1000px; width:100%; clear:both;"></div>

<div style="z-index: 2;"class="alert alert-warning alert-dismissible fade show fixed-bottom" role="alert"> Utilizamos cookies para asegurar que damos la mejor experiencia al usuario en nuestro sitio web. Si continúa utilizando este sitio asumiremos que 
    <strong> está de acuerdo.</strong>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>

<!-- Footer -->
<footer style="z-index: 1;"class="page-footer font-small blue relative-bottom">
    <!-- Copyright -->
    <div class="footer-copyright text-center py-3">© 2020 Copyright:
      <a href="#"> Luis Cotelo</a>
    </div>
</footer>
</body>
</html>