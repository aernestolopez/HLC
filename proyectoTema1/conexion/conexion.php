<?php
$file='php_data.ini';
/* Parseamos el archivo ini y guardamos su contenido en una variable */
$config = parse_ini_file($file);
//Obtenemos los datos del archivo
$servidor=$config['servidor'];
$usuario=$config['usuario'];
$password=$config['password'];
$bd=$config['bd'];
//Nos conectamos a la base de datos
$conecta=new mysqli($servidor, $usuario, $password, $bd);
if($conecta->connect_error){
    die("Error al conectar la base de datos".$conecta->connect_error);
}
?>