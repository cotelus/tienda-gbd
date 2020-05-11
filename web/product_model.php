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


    // A partir de un ID, va a devolver un producto en modo simple
    public function getSimpleProduct($gId){
        $nombre = "";
        $id = $gId;
        $precio = 0;
        $oferta = 0;
        $imagen = "";

        $myJSON = null;

        try{
            $db = Db::conectar();

            // Lo primero va a ser comprobar si existe un producto con este ID
            $sql = $db->prepare("SELECT * FROM productos WHERE id= :id");
            $sql->bindValue(":id", $id);
            $sql->execute();

            if($row = $sql->fetch(PDO::FETCH_ASSOC)){

                // Se enlazan los parámetros
                $id = $row['id'];
                $nombre = $row['nombre'];
                $imagen = $row['imagen'];
                $oferta = $row['oferta'];
                $precio = $row['precio'];

                // Se añaden al array $producto
                $producto = [
                    [
                      "nombre" => $nombre,
                      "id" => $id,
                      "precio" => $precio,
                      "oferta" => $oferta,
                      "imagen" => $imagen
                    ]
                  ];

                // Se codifica el array como JSON para hacerlo mas reutilizable
                $myJSON = json_encode($producto);
            }
            // Se cierra la conexión
            $db = Db::cerrarConexion();

            return $myJSON;

        }catch(Exception $e){
            die("Error: " . $e->getMessage());
        }
    }

    // Modifica un producto en la BBDD
    public function modificaProducto($producto){
        $db=Db::conectar();
        $actualizar=$db->prepare('UPDATE productos SET nombre=:nombre, precio=:precio, oferta=:oferta, imagen=:imagen  WHERE id=:id');
        /*
        $actualizar->bindValue('id',$libro->getId());
        $actualizar->bindValue('nombre',$libro->getNombre());
        $actualizar->bindValue('autor',$libro->getAutor());
        */
        $actualizar->bindValue('id', $producto->getId());
        $actualizar->bindValue('nombre', $producto->getNombre());
        $actualizar->bindValue('precio', $producto->getPrecio());
        $actualizar->bindValue('oferta', $producto->getOferta());
        $actualizar->bindValue('imagen', $producto->getImagen());

        $actualizar->execute();
        
        $db=Db::cerrarConexion();
    }
}
?>