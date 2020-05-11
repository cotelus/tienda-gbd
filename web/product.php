<?php

    class Product{

        // Atributos de clase
        private $nombre;
        private $id;
        private $precio;
        private $precio_final;
        private $oferta;
        private $imagen;

        // Constructor
        function __construct($nombre, $id, $precio, $oferta, $imagen){
            $this->nombre = $nombre;
            $this->id = $id;
            $this->precio = $precio;
            $this->oferta = $oferta;
            $this->imagen = $imagen;
            $this->calcularPrecioFinal();
        }

        // Funciones get/set
            // get
        public function getNombre(){
            return $this->nombre;
        }
        public function getId(){
            return $this->id;
        }
        public function getImagen(){
            return $this->imagen;
        }
        public function getPrecio(){
            return $this->precio;
        }
        public function getOferta(){
            return $this->oferta;
        }
        public function getPrecioFinal(){
            return $this->precio_final;
        }
        // Funciones get/set    
            //set
        public function setNombre($nombre){
            $this->nombre=$nombre;
        }
        public function setId($id){
            $this->id=$id;
        }
        public function setImagen($imagen){
            $this->imagen = $imagen;
        }
        public function setPrecio($precio){
            $this->precio = $precio;
            $this->calcularPrecioFinal();
        }
        public function setOferta($oferta){
            $this->oferta = $oferta;
            $this->calcularPrecioFinal();
        }

        // Calcula el precio final, teniendo en cuenta el precio inicial y la oferta
            // La cosa es que el precio final siempre vaya en función del precio y la oferta, así que en el constructor y cada vez que se cambie el precio o la oferta,
            // el precio final debe calcularse.
            //
            // El ámbito es privado para no poder usarse fuera, que solo pueda cambiarse el precio final desde dentro de la clase, así se asegura 
            // que no sea modificado el precio final sin ser modificados los anteriores.
        private function calcularPrecioFinal(){
            $aux = (double)$this->precio * ((100 - (double)$this->oferta)/100);
            round($aux, 2);
            $this->precio_final = round($aux, 2);
        }
    }
?>