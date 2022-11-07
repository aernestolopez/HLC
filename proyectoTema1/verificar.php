<?php
include './conexion/conexion.php';
session_start();
/* Si el usuario hace clic en entrar se obtiene
el usuario y la contraseña */
if(isset($_POST['entrar'])){
  $user=$conecta->real_escape_string($_POST['usuario']);
  $pass=$conecta->real_escape_string($_POST['contrasenia']);
  
  //Inyeccion SQL.
  $consulta="SELECT * FROM usuario WHERE nick = '$user' and contrasenia = '$pass'";
  
  //Obtenemos los datos de la base de datos
  if($resultado = $conecta->query($consulta)){
    while($row = $resultado->fetch_array()){
      $userCorrecto=$row['nick'];
      $passCorrecto=$row['contrasenia'];

    }
    $resultado->close();
  }
  $conecta->close();
  //Comprobamos que los datos son válidos
  if(isset($user) && isset($pass)){
    if($user==$userCorrecto && $pass==$passCorrecto){
      $_SESSION['login']=TRUE;
      $_SESSION['nick']=$usuario;
      header("location:home.php");
    }else{
     header("location:login.html");
    }
  }
}
?>