<?php
require './conexion/conexion.php';
session_start();
$id=$_SESSION['sesion'];
echo $id;
$sql = "SELECT nick FROM usuario WHERE sesion=:seso";
$stmt= $conecta->prepare($sql);
$stmt->bindParam(":seso", $id, PDO::PARAM_STR);
$stmt->execute();
$elresul = $stmt->fetch(PDO::FETCH_ASSOC);
echo ($elresul['nick']);

if(isset($_POST["submit"])){


    //TODO id de la base de datos nick conseguido mediante la id de sesion

    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if($check !== false){
        $image = $_FILES['image']['tmp_name'];
        $imgContent = addslashes(file_get_contents($image));
        $dataTime = date("Y-m-d H:i:s");
        
        //se inserta la imagen en la bbdd
        $insert =("INSERT into images (nick, image, created) VALUES (:nick, :imagen, :created)");
        $result= $conecta->prepare($insert);
        $result->bindParam(':nick', $nombre);
        $result->bindParam(':imagen', $imgContent);
        $result->bindParam(':created', $dataTime);
        if($result->execute()){
            echo "Se ha subido la imagen correctamente!";
        }else{
            echo "Error al subir la imagen!";
        } 
    }else{
        echo "Seleccione una imagen a subir";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<body>
    <form action="" method="post" enctype="multipart/form-data">
        Selecciona una imagen:
        <input type="file" name="image"/>
        <input type="submit" name="submit" value="UPLOAD"/>
    </form>
</body>
</html>