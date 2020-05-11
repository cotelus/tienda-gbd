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
            //if($num_registro != 0){
            if($row = $result->fetch(PDO::FETCH_ASSOC)){
                if($row["permisos"] == 0){
                    return 1;
                }else{
                    return 2;
                }
            }
            //}
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

    
}
?>