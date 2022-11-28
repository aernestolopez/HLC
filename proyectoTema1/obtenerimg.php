<?php
require'./conexion/conexion.php';
if(isset($_GET['nombre'])){
$sql = "SELECT images, tipo FROM images WHERE nick=:nick";
$query = $conecta->prepare($sql);
$nombre=$_GET['nombre'];
$query->bindParam(":nick", $nombre);
$query->execute();
$result=$query->fetch(PDO::FETCH_ASSOC);
$tipo=$result['tipo'];
header("Content-type: $tipo");
// A continuación enviamos el contenido binario de la imagen.
echo($result['images']);
}
?>