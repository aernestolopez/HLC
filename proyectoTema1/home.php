<?php
require './conexion/conexion.php';
//Obtenemos el id de sesion creada en el login
session_start();
$id=$_SESSION['sesion'];
$sql = "SELECT nick FROM usuario WHERE sesion=:sesion";
$stmt= $conecta->prepare($sql);
$stmt->bindParam(":sesion", $id, PDO::PARAM_STR);
$stmt->execute();
$elresul = $stmt->fetch(PDO::FETCH_ASSOC);
$nombre=$elresul['nick'];

if(isset($_GET['page'])){
  $page = $_GET['page'];
}else{
//Paginacion
$page=1;
}
//Limite de datos por pagina
$limit=40;
$start = ($page - 1) * $limit;

$next = $page + 1;
$previous = $page - 1;
//Obtenemos todos los datos
$query = "SELECT * FROM paginacion LIMIT $start, $limit";
$select = $conecta->prepare($query);
$select->execute();
$results = $select->fetchAll();

//Obtenemos la cantidad de personas en la base de datos
$query_count = "SELECT id FROM paginacion";
$statement = $conecta->query($query_count);
$total_datos = $statement->rowCount();
//Calculamos la cantidad de paginas que vamos a necesitar
$total_paginas = ceil($total_datos / $limit);
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
      <a class="nav-item nav-link active" href="./home.php">Home <span class="sr-only"></span></a>
    </div>
  </div>
    <ul class="nav navbar-nav navbar-right">
      <li>
        <a class="nav-item nav-link" href="./indexup.php">
        <img
          src="obtenerimg.php?nombre=<?=$nombre?>"
          alt="login-icon"
          width="40 px"
          height="40 px"
          class="rounded-circle"
          /></a>
    </li>
    </ul>
  </div>
</nav>
<!--Creamos una alerta por cada dato que exista-->
    <?php foreach($results as $dato): ?>
      <div class="alert alert-primary" role="alert">
        <?php echo("ID: " . $dato['id']." Nombre: ". $dato['first_name']. " Apellido: ". $dato['last_name']. " Correo: " . $dato['email']. " Género: ". $dato['gender'])?>
      </div>
    <?php endforeach?>

    <!--Creamos la navegacion-->
    <nav aria-label="Page navigation">
  <ul class="pagination justify-content-center">
    <!--Mandamos al usuario a la primera pagina-->
  <li class="page-item"><a class="page-link" href="home.php?page=1">Primera</a></li>
  <!--Sie el usuario desea ir una pagina mas atras estando en la primera esta le redirigira a la primera-->
    <li class="page-item"><a class="page-link" href="home.php?page=<?php echo $previous == 0 ? 1 : $previous ?>">Anterior</a></li>
    <?php
    //Hacemos que vayan desapareciendo paginas
    for ($i = 1; $i <= $total_paginas; $i++) {
      $current_page = $page;
      $previous_2 = $current_page - 2;
      $next_2 = $current_page + 2;

      if ($i >= $previous_2 && $i<= $next_2) {
    ?>
    <!--Cuando estemos en una pagina el boton de esta se activara-->
    <li class="page-item <?php echo $i == $page ? 'active' : '' ?>"><a class="page-link" href="home.php?page=<?php echo $i ?>"><?php echo $i ?></a></li>
    <?php
      }
    }?>
    <!--Si el usuario le da a siguiente estando en la ultima pagina esta le redirigirá a esta ultima-->
    <li class="page-item"><a class="page-link" href="home.php?page=<?php echo $next > $total_paginas ? $total_paginas : $next ?>">Siguiente</a></li>
    <!--Mandamos al usuario a la ultima pagina-->
    <li class="page-item"><a class="page-link" href="home.php?page=<?php echo $total_paginas ?>">Última</a></li>
  </nav>
</body>
</html>
