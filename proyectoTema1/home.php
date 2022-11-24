<?php
//Obtenemos el id de sesion creada en el login
session_start();
$id=$_SESSION['sesion'];

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx"
      crossorigin="anonymous"/>
    <script src="https://code.jquery.com/jquery-1.12.4.min.js" 
    integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" 
    crossorigin="anonymous"></script>
  <link rel="shortcut icon" href="./img/logo.ico">

  
  <title>Home</title>
</head>
<body>
    
<nav class="navbar navbar-expand navbar-light bg-light">
  <div class="container-fluid">
    <div class="navbar-brand">
      <img class="img-fluid" src="./img/logo.ico" width="30" height="30" alt="">
    </div>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
    <div class="navbar-nav">
      <a class="nav-item nav-link active" href="#">Home <span class="sr-only"></span></a>
    </div>
  </div>
    <ul class="nav navbar-nav navbar-right">
      <li>
        <a class="nav-item nav-link" href="./indexup.php">
        <span class=""></span> Sign Up</a>
    </li>
    </ul>
  </div>
</nav>
  
<h1>Si estas aqui es porque no la he liado
    </h1>
    <?php
    var_dump($id);
    ?>
</body>
</html>