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
try{
$conecta=new PDO("mysql:host=$servidor;dbname=$bd",$usuario,$password);
}catch(PDOException $e){
    die('Conection Failed: '.$e->getMessage());
}
?>