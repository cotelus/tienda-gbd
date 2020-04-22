<?php
    require_once('user_model.php');
    require_once('user.php');

    $model=new UserModel();
    $user = new User("nouser");

    // Compruebo que se le pasan los datos bien, y si es así, intento iniciar sesión
    if(isset($_POST["username"]) && isset($_POST["password"]) && isset($_POST["passwordConfirmada"])){
        // uso htmlentities y addslashes para evitar inyecciones de codigo sql
        $username=htmlentities(addslashes($_POST["username"]));
        $password=htmlentities(addslashes($_POST["password"]));
        $passwordConfirmada=htmlentities(addslashes($_POST["passwordConfirmada"]));

        // Compruebo que password y passwordConfirmada sean iguales como paso inicial
        if($passwordConfirmada === $password){
            // la funcion register tendrá mas datos en el futuro, pero por ahora solo usuario y contraseña
            $result = $model->register($username, $password);

            // Si result fué verdadero, se lo comunico y le pido que inicie sesión. En caso contrario, vuelvo
            if($result){
                header("location:index.php?login=1");
            }else{
                header("location:index.php?wrongRegister=2");
            }
        }else{
            header("location:index.php?wrongRegister=1");
        }
    }

?>