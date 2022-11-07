<?php
include './conexion/conexion.php';
/* Si el usuario hace clic en entrar se obtiene
el usuario y la contraseña */
if(isset($_POST['entrar'])){
    //Obtenemos los datos introducidos
    $user=$conecta->real_escape_string($_POST['usuario']);
    //Obtenemos la contraseña sin encriptar
    $passSin=$conecta->real_escape_string($_POST['contrasenia']);
    $pass=$conecta->real_escape_string(md5($_POST['contrasenia']));
    //Obtenemos la contraseña sin encriptar
    $pass2Sin=$conecta->real_escape_string($_POST['verificarContrasenia']);
    $pass2=$conecta->real_escape_string(md5($_POST['verificarContrasenia']));
    //Verificamos que las contraseñas sin encriptar tengan una longitud de 8 o mas caracteres 
    if(strlen($passSin)>=8 && strlen($pass2Sin)>=8){
        //Si las constraseñas no coinciden se muestra un error
        if(strcmp($pass, $pass2)!=0){
        echo "Error de contraseña, no coinciden";
        }else{
            //Si todo ha ido bien se inserta en la base de datos estos valores
            $consulta="INSERT INTO usuario (nick, contrasenia) VALUES('$user', '$pass')";
            $conecta->query($consulta);
            $conecta->close();
            //redirigimos al usuario al login
            header("location:login.html");
            }
    }else{
        echo "Error de contraseña, debe tener 8 caracteres o más";
    }
}
?>