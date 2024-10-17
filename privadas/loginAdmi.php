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
    <link rel="stylesheet" href="../styles/login.css"> 
    
    <title>Document</title>
</head>

<body>
   
        
       
    <div class="loginsub">
        <h2>INICIA SESSION ADMINISTRADOR</h2>
    </div>
    
    <div class="loginform">
            <form action="" method="POST">
                <input type="text" name="email" placeholder="EMAIL">
                <input type="text" name="password" placeholder="PASSWORD">
                <input type="submit" value="enviar">
            </form>
    </div>
    <!-- <div class="link-registro">
        <p><a href="registro.php">REGISTRARME COMO USUARIO PARA SUBIR UNA NOTICIA</a></p>
    </div> -->
    
 

    
</body>

</html>

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
    header("Location: ../privadas/listado.php");
    exit();
}


}
