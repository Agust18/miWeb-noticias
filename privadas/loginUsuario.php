<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once("../db/db.php");
@session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/loginUsuario.css">    
    <title>Document</title>
</head>
<body>
    <div class="login">
        <p>Inicio de session</p>
    </div>
    <div>
        <form action="loginUsuario.php" method="POST">
            <div class="email">   
                <input type="email" name="email" placeholder="EMAIL">
            </div>
            <div class="password">
                 <input type="password" name="password" placeholder="PASSWORD">
            </div>
            <div class="buton">
                <input type="submit" value="enviar"> 
            </div>
         
           
            
        </form>
    </div>
    <a href="../publicas/agregarUsuario.php">REGISTRO DE USUARIO</a>
    <a href="../publicas/inicio.php">INICIO</a>

    
</body>
</html>

<?php
$email = isset($_POST["email"]) ? $_POST ["email"] : "";
$password = isset($_POST["password"]) ? $_POST ["password"] : "";

?>

<?php
if (!empty($email) && !empty ($password)){
    $stmt = $conx->prepare("SELECT * FROM usuarios WHERE email = ? AND password = ?");
$stmt->bind_param("ss", $email,$password);
$stmt->execute();
$resultado = $stmt->get_result();
$stmt->close();
$usuario = $resultado->fetch_object();

if ($usuario === NULL){
    echo "usuario o contraseña incorrectos<br>";
    //inicia la session
}else { 
    $_SESSION["id"] = $usuario->id;
    header("Location: ../privadas/agregarNoticia.php");
    exit();
}


}


?>




