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
        try{
            $db=Db::conectar();
            $actualizar=$db->prepare('UPDATE productos SET nombre=:nombre, precio=:precio, oferta=:oferta, imagen=:imagen  WHERE id=:id');
            $actualizar->bindValue('id', $producto->getId());
            $actualizar->bindValue('nombre', $producto->getNombre());
            $actualizar->bindValue('precio', $producto->getPrecio());
            // Si la oferta es mayor de 95, se deja en 95.
            if( $producto->getOferta() > 95){
                $producto->setOferta(95);
            }
            $actualizar->bindValue('oferta', $producto->getOferta());
            $actualizar->bindValue('imagen', $producto->getImagen());

            $actualizar->execute();

            // Se cierra la conexión
            $db = Db::cerrarConexion();
        }catch(Exception $e){
            die("Error: " . $e->getMessage());
        }
    }


    // Elimina un producto de la BBDD
    public function eliminarProducto($id){
        try{
            $db=Db::conectar();
            $eliminar=$db->prepare('DELETE FROM productos WHERE id=:id');
            $eliminar->bindValue('id', $id);

            $eliminar->execute();

            // Se cierra la conexión
            $db = Db::cerrarConexion();
        }catch(Exception $e){
            die("Error: " . $e->getMessage());
        }
    }



    // Comprueba si puede insertar el producto y lo inserta
    public function insertProduct($product){
        $resultado = false;

        try{
            $db = Db::conectar();

            // Lo primero va a ser comprobar si existe este producto.
            $sql = $db->prepare("SELECT * FROM productos WHERE nombre= :nombre");
            $sql->bindValue(":nombre", $product->getNombre());
            $sql->execute();

            $num_registro = $sql->rowCount();

            // Si no devuelve columnas, el nombre de producto está libre, es decir, se puede crear uno nuevo 
            if($num_registro==0){
                $sql = $db->prepare("INSERT INTO `productos` (`id`, `nombre`, `imagen`, `stock`, `precio`, `oferta`) VALUES (NULL, :nombre, :imagen, '200', :precio, :oferta)");
                $sql->bindValue(":nombre",  $product->getNombre());
                $sql->bindValue(":imagen",  $product->getImagen());
                $sql->bindValue(":precio",  $product->getPrecio());
                // Si la oferta es mayor de 95, se deja en 95.
                if( $product->getOferta() > 95){
                    $product->setOferta(95);
                }
                $sql->bindValue(":oferta",  $product->getOferta());

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