<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
//incluimos los archivos de conexion a la base de datos
require_once("../db/db.php");
// require_once("validar.php");



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/agregarUsuario.css">
    <title>Document</title>
</head>
<body>
    <div class="p">
        <p>Registro de usuarios</p>
    </div>
    <div class="form-agg-user">
        <form action="" method="POST">
            <input type="hidden" name="hidden" value="1"> 
            <input type="hidden" name="id" value="<?php echo $id ?>">
            <input type="text" name="nombre" placeholder="NOMBRE">
            <input type="text" name="apellido" placeholder="APELLIDO"> 
            <input type="email" name="email" placeholder="EMAIL">
            <input type="password" name="password" placeholder="PASSWORD">
            <input type="submit" value="enviar">
        </form>
        <div class="volver-inicio">
             <a href="../publicas/inicio.php">volver a Inicio</a>
        </div>
       
    </div>
  
    
</body>
</html>
<?php
$hidden = isset($_POST["hidden"]) ? $_POST ["hidden"] : 0;
$id= isset($_GET["id"]) ? $_GET["id"] : 0 ; 
$nombre = isset($_POST["nombre"]) ? $_POST ["nombre"] : "";
$apellido = isset($_POST["apellido"]) ? $_POST["apellido"] : "";
$email = isset($_POST["email"]) ? $_POST ["email"] : "";
$password = isset($_POST["password"]) ? $_POST ["password"] : "";
?>

<?php
if ($hidden == "1") {
    $error=0;
    $mensaje= "";
    
    if (empty($nombre)){
        $error = 1;
        $mensaje = "porfavor ingrese su nombre";

    }

    if (empty($apellido) ){
        $error = 1;
        $mensaje = "Ingrese su apellido";
    }

    if (empty($email)){
        $error = 1;
        $mensaje = "por favor ingrese su email";
    }

    if (empty($password)){
        $error = 1;
        $mensaje = "por favor ingrese un password para su cuenta";
    }

    if ($error == 0){
        if ($id == 0) {				
            $sql = "INSERT INTO usuarios (nombre,apellido,email,password) VALUES (?, ?, ?, ?) ";
            $stmt = $conx->prepare($sql);
            $stmt->bind_param("sssi", $nombre,$apellido,$email,$password);
            $stmt->execute();
            $stmt->close();
        } 
        header("Location: ../privadas/loginUsuario.php");
        exit();
    } else {
        echo $mensaje;
    }
}

$sql = "SELECT * FROM usuarios WHERE id = ? ";

	$stmt = $conx->prepare($sql);
	$stmt->bind_param("i", $id);
	$stmt->execute();

	$resultado = $stmt->get_result();

	$usuario = $resultado->fetch_object();

	$stmt->close();
?>