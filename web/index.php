<?php
    // las variables superglobales de sesion deben usarse antes de enviar las cabeceras de la página

    session_start();
    if(isset($_SESSION["username"])){
        $username = $_SESSION["username"];
    }

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
        <div class="">   

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