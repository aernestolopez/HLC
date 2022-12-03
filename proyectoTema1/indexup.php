<?php
$mensaje='';
require './conexion/conexion.php';
session_start();
$id=$_SESSION['sesion'];
$sql = "SELECT nick, nickname FROM usuario WHERE sesion=:sesion";
$stmt= $conecta->prepare($sql);
$stmt->bindParam(":sesion", $id, PDO::PARAM_STR);
$stmt->execute();
$elresul = $stmt->fetch(PDO::FETCH_ASSOC);
$nombre=$elresul['nick'];
$nickname=$elresul['nickname'];

if(isset($_POST["submit"])){
    $permitidos = array("image/jpg", "image/jpeg", "image/gif", "image/png");
    $limite_kb = 16384;
    if(isset($_FILES['image'])&&in_array($_FILES['image']['type'], $permitidos) && $_FILES['image']['size'] <= $limite_kb * 1024){
        $imagentemporal = $_FILES['image']['tmp_name'];
        $fp=fopen($imagentemporal,'r+b');
        $data=fread($fp,filesize($imagentemporal));
        fclose($fp);
        $dataTime = date("Y-m-d H:i:s");
        $tipo=$_FILES['image']['type'];
            $update=("UPDATE images SET images=? ,tipo=?, created=? WHERE nick=?");
            $stmt2=$conecta->prepare($update);
            $stmt2->execute([$data, $tipo,$dataTime,$nombre]);
        //Cambio de nickname, al recargar la pagina se visualiza
        $nombreCambiado=($_POST['Cambiousuario']);
        $sentenciaUpdate=("UPDATE usuario SET nickname=? WHERE nick=?");
        $stmt3=$conecta->prepare($sentenciaUpdate);
        $stmt3->execute([$nombreCambiado, $nombre]);
    }else{
        $mensaje= "Error al subir la imagen o imagen vacia";
    }
}
if(isset($_POST["borrar"])){
$drop=("DELETE FROM usuario WHERE nick=?");
$borrar=$conecta->prepare($drop);
$borrar->execute([$nombre]);
$drop2=("DELETE FROM images WHERE nick=?");
$borrar2=$conecta->prepare($drop2);
$borrar2->execute([$nombre]);
session_unset();
session_destroy();
header("location:login.php");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="./img/logo.ico">
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx"
      crossorigin="anonymous"/>
    <script src="https://code.jquery.com/jquery-1.12.4.min.js" 
    integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" 
    crossorigin="anonymous"></script>
  
  <title>Editar Usuario</title>
</head>
<body>
<nav class="navbar navbar-expand navbar-light bg-light">
  <div class="container-fluid">
    <div class="navbar-brand">
      <img class="img-fluid" src="./img/logo.ico" width="30" height="30" alt="">
    </div>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
    <div class="navbar-nav">
      <a class="nav-item nav-link" href="./home.php">Home <span class="sr-only"></span></a>
    </div>
  </div>
    <ul class="nav navbar-nav navbar-right">
      <li>
        <a class="nav-item nav-link active" href="./indexup.php">
        <img
          src="obtenerimg.php?nombre=<?=$nombre?>"
          alt="login-icon"
          width="40 px"
          height="40 px"
          class="rounded-circle"
          />
      </div></a>
    </li>
    </ul>
  </div>
</nav>
<div class="container d-flex justify-content-center">
<div
      class="bg-white p-5 rounded-5 text-secondary shadow"
      style="width: 25rem">
      <div class="d-flex justify-content-center">
        <img
          src="obtenerimg.php?nombre=<?=$nombre?>"
          alt="login-icon"
          width="130 px"
          height="130 px"
          class="rounded-circle"
          style="height: 7rem"/>
      </div>
      <!--nombre del usuario que inicia sesion-->
      <div class="text-center fs-1 fw-bold">
        <?php if(!empty($nickname)): ?>
        <p><?=$nickname?></p>
        <?php endif; ?></div>
        <!--seleccion de imagen-->
      <form action="" method="post" enctype="multipart/form-data">
        Editar nombre de usuario
        <input
          class="form-control bg-light"
          name="Cambiousuario"
          type="text"
          value="<?=$nickname?>"
          />
        Selecciona una imagen:
        <input type="file" name="image"/>
        <br>
        <br>
        <?php if(!empty($mensaje)):?>
          <p style="color:red"><?=$mensaje?></p>
          <?php endif;?>
        <input type="submit" name="submit" value="Subir"/>

        <div class="d-flex gap-1 justify-content-center mt-1">
        <p style="color:red">¿Quiere borrar la cuenta?</p>
        <input type="submit" name="borrar" value="Borrar"/>
    </form>
      </div>
      </div>
</body>
</html>
