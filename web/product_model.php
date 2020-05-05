<?php
// Incluyo la conexion a la BD
require_once('conexion.php');
require_once('product.php');

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

            $contador = 0;
            while($row = $sql->fetch(PDO::FETCH_ASSOC)){
                $productList[$contador]=array(
                    $row['id'],
                    $row['nombre'], 
                    $row['imagen'],
                    $row['precio'],
                    $row['oferta']
                );
                $contador++;
            }

            return $productList;

            $db = Db::cerrarConexion();

        }catch(Exception $e){
            die("Error: " . $e->getMessage());
        }
    }


    // A partir de un ID, va a devolver un producto completo
    public function getProduct($gId){
        $nombre = "";
        $id = $gId;
        $precio = 0;
        $precio_final = 0;
        $oferta = 0;
        $imagen = "";


    }
}
?>