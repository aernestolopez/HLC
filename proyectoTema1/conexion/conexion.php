<?php
$servidor="localhost";
$usuario="root";
$password="";
$bd="login";
$conecta=mysqli_connect($servidor, $usuario, $password, $bd);

if($conecta->connect_error){
    die("Error al conectar la base de datos".$conecta->connect_error);
}
?>