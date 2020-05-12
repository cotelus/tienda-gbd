<?php

    require_once("user_model.php");

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
        </div>  

        <div class="col-12">
            <h1> Historial de compras </h1>
            <?php 
                // Se pide a user_model el listado de todas las facturas de este usuario
                $facturas = UserModel::getFacturas($_SESSION["username"]);
                print_r($facturas);
                ?>

                <table class="table table-striped">
                    <thead>
                        <tr>
                        <th scope="col">Nº Factura</th>
                        <th scope="col">Fecha</th>
                        <th scope="col">Importe</th>
                        <th scope="col">Detalle</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($facturas as $key => $factura){ ?>
                            <tr>
                                <th scope="row">#<?php echo $factura['id_factura']?></th>
                                <td><?php echo $factura['fecha']?></td>
                                <td><?php echo $factura['importe_total'] ?> €</td>
                                <td><a href="facturaDetalle.php?id=<?php echo $factura['id_factura'] ?>"><button type="button" name="actualizar" class="btn btn-success col-12">Ver en detalle</button></a></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                    
        </div> 

        <div class="col-12">
            <br>
            <hr>
            <a type="button" class="ml-2 btn btn-danger" href="close_session.php">Cerrar sesión</a>
            <br>
            <hr>
            <a type="button" class="ml-2 btn btn-primary" href="index.php">Volver al inicio</a>
        </div>
    </div>
</div>



</body>
</html>