<?php
require './conexion/conexion.php';
$error='';
/* Si el usuario hace clic en entrar se obtiene
el usuario y la contraseña */
if(isset($_POST['entrar'])){
    //Obtenemos los datos introducidos
    $user=($_POST['usuario']);
    //Obtenemos la contraseña sin encriptar
    $passSin=($_POST['contrasenia']);
    $pass=(md5($_POST['contrasenia']));
    //Obtenemos la contraseña sin encriptar
    $pass2Sin=($_POST['verificarContrasenia']);
    $pass2=(md5($_POST['verificarContrasenia']));
    //Verificamos que las contraseñas sin encriptar tengan una longitud de 8 o mas caracteres 
    if(strlen($passSin)>=8 && strlen($pass2Sin)>=8){
        //Si las constraseñas no coinciden se muestra un error
        if(strcmp($pass, $pass2)!=0){
        $error="Error de contraseña, no coinciden";
        }else{
              $consulta=$conecta->prepare('SELECT nick FROM usuario WHERE nick = :nick');
              $consulta->bindParam(':nick',$user);
              $consulta->execute();
              $resultado=$consulta->fetch(PDO::FETCH_ASSOC);
            if(strcmp($resultado['nick'],$user)!=0){
            //Si todo ha ido bien se inserta en la base de datos estos valores
            $consultaInsert="INSERT INTO usuario (nick, contrasenia) VALUES(:nick , :contrasenia)";
            $resultado= $conecta->prepare($consultaInsert);
            $resultado->bindParam(':nick', $_POST['usuario']);
            $resultado->bindParam(':contrasenia', $pass);
            if($resultado->execute()){
              //redirigimos al usuario al login
              header("location:login.php");
            }else{
              $error="Error de verificacion";
            }
            }else {
                $error="El usuario ya existe";
            }
        }
    }else{
      $error="Error de contraseña, debe tener 8 caracteres o más";
 }
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
          src="./img/agregar.png"
          alt="login-icon"
          style="height: 7rem"/>
      </div>
      <form action="" method="post">
      <div class="text-center fs-1 fw-bold">Crear Cuenta</div>
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
        <div class="input-group mt-1">
            <div class="input-group-text bg-light">
              <img
                src="./img/pass.png"
                alt="password-icon"
                style="height: 1rem"/>
            </div>
        <input
        class="form-control"
          name="verificarContrasenia"
          type="password"
          placeholder="Verificar Contraseña"/>
      </div>
      <?php if(!empty($error)): ?>
        <p style="color:red"><?=$error?></p>
        <?php endif; ?>
      <input class="btn btn-primary text-white w-100 mt-4 fw-semibold shadow-sm" 
      type="submit" value="Crear Cuenta" name="entrar">
      </input>
      <div class="d-flex gap-1 justify-content-center mt-1">
        <div>¿Tienes Cuenta?</div>
        <a href="./login.php" class="text-decoration-none text-info fw-semibold">
          Inicia Sesión
        </a>
      </div>
      </form>
  </body>
</html>