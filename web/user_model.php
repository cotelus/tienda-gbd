<?php

// Incluyo la conexion a la BD
require_once('conexion.php');

class UserModel{

    public function __construct(){}

    // Comprueba si el usuario y contraseña es correcto en el servidor
        //  Devuelve: 0 - Usuario no existe en el sistema
        //  Devuelve: 1 - Usuario existe pero no tiene permisos de administración
        //  Devuelve: 2 - Usuario existe y tiene permisos de administración
    public function login($username, $password){
        try{
            $db = Db::conectar();
            $result = $db->prepare("SELECT * FROM usuarios WHERE nombre= :login AND contrasena= :password");
            $result->bindValue(":login", $username);
            $result->bindValue(":password", $password);
            $result->execute();
    
            $num_registro = $result->rowCount();

            $db = Db::cerrarConexion();
    
            // El usuario existe y la contraseña coincide
            if($row = $result->fetch(PDO::FETCH_ASSOC)){
                if($row["permisos"] == 0){
                    return 1;
                }else{
                    return 2;
                }
            }
            // El usuario no existe o la contraseña no coincide
            else{
                return 0;
            }
    
        }catch(Exception $e){
            die("Error: " . $e->getMessage());
        }
    }

    // Comprueba si el usuario puede registrarse con esos datos y actua en consecuencia
    public function register($username, $password){
        $resultado = false;

        try{
            $db = Db::conectar();

            // Lo primero va a ser comprobar si existe este usuario.
            $sql = $db->prepare("SELECT * FROM usuarios WHERE nombre= :username");
            $sql->bindValue(":username", $username);
            $sql->execute();

            $num_registro = $sql->rowCount();

            // Si no devuelve columnas, el nombre de usuario está libre, es decir, se puede crear uno nuevo 
            if($num_registro==0){
                $sql = $db->prepare("INSERT INTO `usuarios`( `nombre`, `contrasena`) VALUES (:username, :password)");
                $sql->bindValue(":username", $username);
                $sql->bindValue(":password", $password);

                $sql->execute();

                $resultado = true;
            }

            $db = Db::cerrarConexion();

            return $resultado;

        }catch(Exception $e){
            die("Error: " . $e->getMessage());
        }
    }

    // Añade la factura relacionando un id de factura, el id de usuario y los productos del carro en formato JSON
    public function crearFactura($usuario, $carro, $importe_total){
        $resultado = false;

        // Se pregunta por el id y se almacena
        $id = UserModel::getUserId($usuario);

        try{
            $db = Db::conectar();

            // Se prepara la consulta
            $sql = $db->prepare("INSERT INTO `factura` (`id_factura`, `usuario`, `fecha`, `carro`, `importe_total`) VALUES (NULL, :id, NOW(), :carro, :importe_total)");
            $sql->bindValue(":id", $id);
            $sql->bindValue(":carro", $carro);
            $sql->bindValue(":importe_total", $importe_total);

            $sql->execute();

            $resultado = true;

        }catch(Exception $e){
            die("Error: " . $e->getMessage());
        }

        $db = Db::cerrarConexion();
        return $resultado;
    }

    public function getUserId($username){
        $resultado = false;

        try{
            $db = Db::conectar();

            // Lo primero va a ser comprobar si existe este usuario.
            $sql = $db->prepare("SELECT * FROM usuarios WHERE nombre= :username");
            $sql->bindValue(":username", $username);
            $sql->execute();

            $num_registro = $sql->rowCount();

            // Si el numero de registros no es 0, el usuario existe, por lo tanto, devuelvo los datos necesarios
            if($num_registro != 0){
                if($row = $sql->fetch(PDO::FETCH_ASSOC)){
                    $resultado = $row["id"];
                }
            }

            $db = Db::cerrarConexion();

            return $resultado;

        }catch(Exception $e){
            die("Error: " . $e->getMessage());
        }
    }

    // A partir de un usuario y un id de factura, se devuelve si la factura pertenece a ese usuario
    public function getFacturaConcreta($username, $id_factura){
        
        $id = UserModel::getUserId($username);

        try{
            $db = Db::conectar();
            $result = $db->prepare("SELECT * FROM factura WHERE id_factura= :id_factura AND usuario= :usuario");
            $result->bindValue(":id_factura", $id_factura);
            $result->bindValue(":usuario", $id);
            $result->execute();
    
            $num_registro = $result->rowCount();

            $db = Db::cerrarConexion();
    
            // El id_factura y el id_usuario se corresponden
            if($row = $result->fetch(PDO::FETCH_ASSOC)){
                if(isset($row["carro"])){
                    $factura = array();
                    $factura["carro"] = $row["carro"];
                    $factura["id_factura"] = $row["id_factura"];
                    $factura["fecha"] = $row["fecha"];
                    $factura["importe_total"] = $row["importe_total"];

                    return $factura;

                }
            }
            // El id_factura y el id_usuario no se corresponden
            else{
                return NULL;
            }
    
        }catch(Exception $e){
            die("Error: " . $e->getMessage());
        }
    }

    // A partir de un usuario y un id de factura, se devuelve si la factura pertenece a ese usuario
    public function getFacturas($username){
        
        $id = UserModel::getUserId($username);

        try{
            $db = Db::conectar();
            $result = $db->prepare("SELECT * FROM factura WHERE usuario= :usuario");
            $result->bindValue(":usuario", $id);
            $result->execute();
    
            $num_registro = $result->rowCount();
            
            $facturas = array();
            $index = 0;
            // Para cada fila devuelta por la BBDD se almacena en $facturas
            while($row = $result->fetch(PDO::FETCH_ASSOC)){
                if(isset($row["carro"])){
                    $facturas[$index]["carro"] = json_decode($row["carro"], true);
                    $facturas[$index]["id_factura"] = $row["id_factura"];
                    $facturas[$index]["fecha"] = $row["fecha"];
                    $facturas[$index]["importe_total"] = $row["importe_total"];

                    $index++;
                }
            }

            $db = Db::cerrarConexion();

            return $facturas;


    
        }catch(Exception $e){
            die("Error: " . $e->getMessage());
        }
    }

    
}
?>