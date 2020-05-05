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
            $this->precio_final = (double)$this->precio * ((100 - (double)$this->oferta)/100);
        }

        // Funciones get/set
            // get
        public function getNombre(){
            return $this->nombre;
        }
        public function getPrecioFinal(){
            return $this->precio_final;
        }

        public function getId(){
            return $this->id;
        }

            //set
        public function setNombre($nombre){
            $this->nombre=$nombre;
        }
        public function setPrecioFinal($precio_final){
            $this->precio_final=$precio_final;
        }
        public function setId($id){
            $this->id=$id;
        }
    }
?>