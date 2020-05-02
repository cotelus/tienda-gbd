<?php
// Incluyo la conexion a la BD
require_once('conexion.php');

class ProductModel{

    private $productList = array();

    private function __construct(){}

    // Rellena la variable globarl $_ProductList con los productos que haya en el servidor
     public function getProductList(){
        try{
            $db = Db::conectar();

            // Lo primero va a ser comprobar si existe este usuario.
            $sql = $db->prepare("SELECT * FROM productos");
            $sql->execute();



            $cars = array(
                array("Volvo",22,18),
                array("BMW",15,13),
                array("Saab",5,2),
                array("Land Rover",17,15)
            );



            $contador = 0;
            while($row = $sql->fetch(PDO::FETCH_ASSOC)){
                $productList[$contador]=array(
                    $row['nombre'], 
                    $row['imagen'],
                    $row['precio']
                );
                $contador++;
            }

            return $productList;

            $db = Db::cerrarConexion();

        }catch(Exception $e){
            die("Error: " . $e->getMessage());
        }
    }
}
?>