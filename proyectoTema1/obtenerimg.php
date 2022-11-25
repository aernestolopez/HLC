<?php
require'./conexion/conexion.php';
if(isset($_GET['nombre'])){
$sql = "SELECT images FROM images WHERE nick=:nick";
$query = $conecta->prepare($sql);
$nombre='rafa';
$query->bindParam(":nick", $nombre);
$query->execute();
$result=$query->fetch(PDO::FETCH_ASSOC);

header("Content-type: image/jpeg");
// A continuación enviamos el contenido binario de la imagen.
echo($result['images']);
}
?>