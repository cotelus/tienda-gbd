<?php

    class Db{

        private static $conexion = NULL;
        private function __construct(){}

        // Esto está aquí en el modo local para probar. En el servidor tiene un usuario específico para la BBDD
        private static $usuario = "root";
        private static $contrasena = "";  
        private static $servidor = "localhost";
        private static $basededatos = "tienda";

        public static function conectar(){
            $pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
            self::$conexion = new PDO("mysql:host=". self::$servidor .";dbname=". self::$basededatos ."", self::$usuario, self::$contrasena, $pdo_options);
            return self::$conexion;
        }

        // Cierra la conexión, para que no haya problemas por si una conexión no se reinició correctamente
        public static function cerrarConexion(){
            self::$conexion = NULL;
        }
    }
?>