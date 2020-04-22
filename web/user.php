<?php

    class User{

        // Atributos de clase
        private $name;
        private $password;
        private $id;

        // Constructor
            // No quiero almacenar contrasena ni id en el host, así que toman valores por defecto.
            // Lo dejo indicado aún así por si hiciera falta, en labores de administración cambiar
            // la contraseña o el id de algún usuario.
            // Esta clase también va a ser necesaria cuando haya parámetros del usuario que mostrar, pero como digo, ahora mismo
            // es mas por dejarlo indicado, ya que solo se muestra el nombre y este se almacena en la sesion
        function __construct($name, $password="", $id=-1){
            $this->name = $name;
            $this->password = $password;
            $this->id = $id;
        }

        // Funciones get/set
            // get
        public function getName(){
            return $this->name;
        }
        public function getPassword(){
            return $this->password;
        }

        public function getId(){
            return $this->id;
        }

            //set
        public function setName($name){
            $this->name=$name;
        }
        public function setPassword($password){
            $this->password=$password;
        }
        public function setId($id){
            $this->id=$id;
        }
    }
?>