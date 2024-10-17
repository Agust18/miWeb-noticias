<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once("../db/db.php");
//iniciar session 
@session_start();


// SELECT * FROM usuarios WHERE email = ? AND password = ?


?>

<h2>INICIA SESSION ADMINISTRADOR</h2>
<form method="post">
    <input type="email" name="email" placeholder="ingrese su email" required>
    <input type="password" name="password" placeholder="ingrese su contraseña" required>
    <input type="submit"><br>
    

</form>
<p><a href="registro.php">REGISTRO DE USUARIO</a></p> 

<?php
$email = isset($_POST["email"]) ? $_POST["email"] : "";
$password = isset($_POST["password"]) ? $_POST["password"] : "";

if (!empty($email) && !empty ($password)){
    $stmt = $conx->prepare("SELECT * FROM administradores WHERE email = ? AND password = ?");
$stmt->bind_param("ss", $email,$password);
$stmt->execute();
$resultado = $stmt->get_result();
$stmt->close();
$usuario = $resultado->fetch_object();

if ($usuario === NULL){
    echo "usuario o contraseña incorrectos<br>";
    //inicia la session
}else { $_SESSION["id"] = $usuario->id;
    header("Location: listado.php");
    exit();
}


}



// $stmt = $conx->prepare("SELECT * FROM administradores WHERE email = ? AND password = ?");
// $stmt->bind_param("ss", $email,$password);
// $stmt->execute();
// $resultado = $stmt->get_result();
// $stmt->close();
// $usuario = $resultado->fetch_object();

// if ($usuario === NULL){
//     echo "usuario o contraseña incorrecta<br>";
//     //inicia la session
// }else { $_SESSION["id"] = $usuario->id;
//     header("Location: listado.php");
//     exit();
// }

?>