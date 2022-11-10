<?php
require './conexion/conexion.php';
$error='';
/* Si el usuario hace clic en entrar se obtiene
el usuario y la contraseña */
if(isset($_POST['entrar'])){
  $user=($_POST['usuario']);
  $pass=(md5($_POST['contrasenia']));
  
  //Inyeccion SQL.
  $consulta="SELECT * FROM usuario WHERE nick = '$user' and contrasenia = '$pass'";
  
  //Obtenemos los datos de la base de datos
  if($resultado = $conecta->query($consulta)){
    while($row = $resultado->fetch_array()){
      $userCorrecto=$row['nick'];
      $passCorrecto=$row['contrasenia'];

    }
    //cerramos la conexion
    $resultado->close();
  }
  
  //Comprobamos que los datos son válidos
  if(isset($user) && isset($pass)){
    if($user==$userCorrecto && $pass==$passCorrecto){
      //creamos la sesion si los datos son válidos
      session_start();
      $_SESSION['prueba'];
      //obtenemos el id de la sesion
      $id=session_id();
      //Creamos un Update para poder añadir el id de la sesion a la base de datos
      $consulta2= "UPDATE usuario SET sesion='$id' WHERE nick='$userCorrecto'";
      $conecta->query($consulta2);
      header("location:home.php");
    }else{
     $error='Los datos no son válidos';
    }
  }
  $conecta->close();
}
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Iniciar Sesión</title>
    <script src="https://code.jquery.com/jquery-1.12.4.min.js" 
    integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" 
    crossorigin="anonymous"></script>
    <link rel="shortcut icon" href="./img/logo.ico">
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx"
      crossorigin="anonymous"/>
    <link rel="stylesheet" href="./estilos.css"/>
  </head>
  <body class="d-flex justify-content-center align-items-center vh-100">
    <div
      class="bg-white p-5 rounded-5 text-secondary shadow"
      style="width: 25rem">
      <div class="d-flex justify-content-center">
        <img
          src="./img/user.png"
          alt="login-icon"
          style="height: 7rem"/>
      </div>
      <form action="" method="post">
      <div class="text-center fs-1 fw-bold">Bienvenido/a de nuevo</div>
      <div class="input-group mt-4">
        <div class="input-group-text bg-light">
          <img
            src="./img/usuario.png"
            alt="username-icon"
            style="height: 1rem"/>
        </div>
        <input
          class="form-control bg-light"
          name="usuario"
          type="text"
          placeholder="Usuario"/>
      </div>
      <div class="input-group mt-1">
        <div class="input-group-text bg-light">
          <img
            src="./img/pass.png"
            alt="password-icon"
            style="height: 1rem"/>
        </div>
        <input
          class="form-control bg-light"
          name="contrasenia"
          type="password"
          placeholder="Contraseña"/>
      </div>
      <!--mostramos el mensaje de error-->
      <?php if(!empty($error)): ?>
        <p style="color:red"><?=$error?></p>
        <?php endif; ?>
      <div class="d-flex justify-content-around mt-1">
        <div class="d-flex align-items-center gap-1">
          <input class="form-check-input" type="checkbox" name="recordar"/>
          <div class="pt-1" style="font-size: 0.9rem">Recuérdame</div>
        </div>
      </div>
      <input class="btn btn-primary text-white w-100 mt-4 fw-semibold shadow-sm" 
      type="submit" value="Iniciar Sesión" name="entrar">
      </input>
      </form>
      <div class="d-flex gap-1 justify-content-center mt-1">
        <div>¿No tienes cuenta?</div>
        <a href="./singup.php" class="text-decoration-none text-info fw-semibold">
          Registrarse</a>
      </div>
  </body>
</html>