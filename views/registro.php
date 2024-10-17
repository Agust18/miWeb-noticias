<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once("../db/db.php");


?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>formulario</title>
    
</head>
<body>
    <form  Method="POST">
        <input type='hidden' name="envio_formulario" value='1'>  
        <label for="">Registre su usuario</label><br>
        <input type="text"  name="nombre" ><br>
        <label for="">fecha_creacion</label><br>
        <input type="datetime-local"   name="fecha_creacion" ><br>
        <br><label for="descripcion">Descripcion</label><br>
        <textarea name="descripcion" rows="5"></textarea>
        <br><label>edad</label><br>
        <input type="number" name="edad" ><br>
        <input type="submit"  value="enviar">
    </form>
    
    <a href="login.php">login administradores</a>





<?php
$id= isset($_GET["id"]) ? $_GET["id"] : 0 ; 
$nombre = isset($_POST["nombre"]) ? $_POST ["nombre"] : "";
$descripcion = isset($_POST["descripcion"])  ? $_POST ["descripcion"] : "";
$fecha_creacion = isset($POST["fecha"])  ? $_POST ["fecha"] : date("Y-m-d H:i:s");
$edad = isset($_POST["edad"]) ? $_POST ["edad"] : 0;
$hidden = isset($_POST["envio_formulario"]) ? $_POST ["envio_formulario"] : 0;

if ($hidden == "1") {
    $error=0;
    $mensaje = "";
    if (empty($nombre)){
        $error = 1;
        $mensaje = "porfavor ingrese su nombre";

    }

    if (empty($fecha_creacion) ){
        $error = 1;
        $mensaje = "Ingrese una fecha valida";
    }

    if (empty($descripcion)){
        $error = 1;
        $mensaje = "por favor ingrese una descripcion";
    }

    if (empty($edad)){
        $error = 1;
        $mensaje = "por favor ingrese su edad";

    }

    
    
    if ($error == 0){
        $sql = "INSERT INTO usuarios (nombre, fecha_creacion, descripcion, edad) VALUES (?, ?, ?, ?) ";
        $stmt = $conx->prepare($sql);
        $stmt->bind_param("sssi", $nombre, $fecha_creacion, $descripcion, $edad);
        $stmt->execute();
        $stmt->close();
        header("Location: mensajeUser.php");
        exit();
    }else {
        echo $mensaje;
    }
    // header("Location:mensajeUser.php");
    // exit();       
    
}  






?>




    
    

   
</body>
</html>