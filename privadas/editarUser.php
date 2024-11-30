<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once("../db/db.php");
?>
<?php

$id= isset($_GET["id"]) ? $_GET["id"] : 0 ; 

if ($id!=0){
    $sql=("SELECT * FROM usuarios where id=?");
    $stmt=$conx->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $resultadoStmt=$stmt->get_result();
    $resultado=$resultadoStmt->fetch_object();

    $nombre = $resultado->nombre;
    $apellido = $resultado->apellido;
    $email = $resultado->email;
    $password = $resultado->password;
    $eliminado = $resultado->eliminado;


}else{
    $nombre = "";
    $apellido = "";
    $email = "";
    $password = "";

}




?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/header.css">    
    <link rel="stylesheet" href="../styles/listado.css">
      
    <title></title>
</head>
<header>
    <h2>ADMISNITRADOR</H2>
    <div>
       <nav class="nav-links">
            <ul>
                <li><a href="listado.php">usuarios</a></li>
                <li><a href="listadoNoticias.php">Noticias</a></li>
                <li><a href="listadoCategorias.php">categorias</a></li>
                <li><a href="editarUser.php">agregar Usuario</a></li>
               

            </ul> 
        </nav>
    </div>
</header>


<body>
    <div class="listadosub">
         <h2>AGREGAR USUARIS</h2>
    </div>
    <div class="table">
    <div class="formu">
        <form method="POST">
            <input type="hidden" name='hidden' value="1"> 
            <?php if($id!=0){ ?>
                <input type="hidden" name="id" value="<?php echo $id ?>">
                <?php }
                ?>
            <input type="text" name="nombre" placeholder="Nombre" value="<?php echo $nombre ?>" >
            <input type="text" name="apellido" placeholder="Apellido" value="<?php echo $apellido ?>">
            <input type="email" name="email" placeholder="Email" value="<?php echo $email ?>">
            <input type="text" name="password" placeholder="Password" value="<?php echo $password ?>">
            <?php 
            if ($id>0){ ?>
            <input type ="number" name="eliminado"  value="<?php echo $eliminado?>">
            <input type="submit" value="editar">
            <?php 

            } else {
                ?>
                 <input type="submit" value="agregar">
            <?php
            } ?>
         

        </form>
    </div>
    </div>
   
    <div class="listadoformulario">
        <form action="../controles/cerrarAdmi.php" method="POST">
            <input type="submit"  value="cerrar session">
        </form>
    </div>
<body>
   
    
</body>
</html>

<?php
$hidden = isset($_POST["hidden"]) ? intval($_POST ["hidden"]) : 0;
$nombre = isset($_POST["nombre"]) ? $_POST ["nombre"] : "";
$apellido = isset($_POST["apellido"]) ? $_POST["apellido"] : "";
$email = isset($_POST["email"]) ? $_POST ["email"] : "";
$password = isset($_POST["password"]) ? $_POST ["password"] : "";
$eliminado = isset($_POST["eliminado"]) ? $_POST ["eliminado"] : 0;

// Si se ha enviado el formulario, actualizamos el usuario
if ($hidden != 0 && $id > 0) {
    $sqlEdit = 'UPDATE usuarios SET nombre = ?, apellido = ?, email = ?, password = ?, eliminado = ? WHERE id = ?';
    $stmt = $conx->prepare($sqlEdit);
    $stmt->bind_param("ssssii", $nombre, $apellido, $email, $password,$eliminado, $id);
    $stmt->execute();
    $stmt->close();
    
    header("Location: listado.php");
    exit;
}

if ($hidden != 0 && $id == 0) {
    $sqlAgg = 'insert into usuarios ( nombre ,apellido , email , password) values (?,?,?,?) ';
    $stmt = $conx->prepare($sqlAgg);
    $stmt->bind_param("ssss", $nombre, $apellido, $email, $password);
    $stmt->execute();
    $stmt->close();
    
    header("Location: listado.php");
    exit;
}

?>
