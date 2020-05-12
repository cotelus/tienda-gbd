<?php
    // las variables superglobales de sesion deben usarse antes de enviar las cabeceras de la página

    session_start();

    if(!isset($_SESSION["username"])){
        header("Location:index.php?wrongLogin=1");
    }
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <title> login </title>
</head>

<body>


<div class="container-fluid">
    <div class="row text-center" >
        <div class="col-12">
            <h1> Bienvenido <?php print $_SESSION['username']; ?></h1>
            <p> Información para usuarios registrados</p>

            <a type="button" class="ml-2 btn btn-danger" href="close_session.php">Cerrar sesión</a>
            <br>
            <hr>
            <a type="button" class="ml-2 btn btn-primary" href="index.php">Volver al inicio</a>
        </div>
    </div>
</div>



</body>
</html>