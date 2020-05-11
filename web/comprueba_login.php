<?php
    require_once('user_model.php');
    require_once('user.php');

    $model=new UserModel();
    $user = new User("nouser");

    // Compruebo que se le pasan los datos bien, y si es así, intento iniciar sesión
    if(isset($_POST["username"]) && isset($_POST["password"])){
        // uso htmlentities y addslashes para evitar inyecciones de codigo sql
        $username=htmlentities(addslashes($_POST["username"]));
        $password=htmlentities(addslashes($_POST["password"]));

        // Aún no uso el usuario de la clase, pero lo dejo aquí indicado para futuras versiones
        $user->setName($username);

        // Comprueba si el usuario pudo iniciar sesión correctamente
        $resultado = $model->login($username, $password);

        // En función de lo que devuelva login, se actua
        if($resultado != 0){
            session_start();
            if($resultado == 1){
                $_SESSION["username"] = $username;
                $_SESSION["admin"] = 0;
                header("location:user_panel.php?admin=0");
            }
            if($resultado == 2){
                $_SESSION["username"] = $username;
                $_SESSION["admin"] = 1;
                header("location:user_panel.php?admin=1");
            }
        }else{
            header("location:index.php?wrongLogin=1");
        }
    }

?>