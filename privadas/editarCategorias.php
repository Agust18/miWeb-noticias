<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once("../db/db.php");
?>
<?php

$id= isset($_GET["id"]) ? $_GET["id"] : 0 ; 

if ($id!=0){
    $sql=("SELECT * FROM categorias where id=?");
    $stmt=$conx->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $resultadoStmt=$stmt->get_result();
    $resultado=$resultadoStmt->fetch_object();

    $categoria = $resultado->categoria;
   


}else{
    $categoria = "";
   

}




?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/listado.css">
    <title>Document</title>
</head>
<body>
    <div class="formu">
        <form method="POST">
            <input type="hidden" name='hidden' value="1"> 
            <?php if($id!=0){ ?>
                <input type="hidden" name="id" value="<?php echo $id ?>">
                <?php }
                ?>
            <input type="text" name="categoria" placeholder="Categoria" value="<?php echo $categoria ?>" >           
            <?php 
            if ($id>0){ ?>
           
            <input type="submit" value="editar">
            <?php 

            } else {
                ?>
                 <input type="submit" value="agregar">
            <?php
            } ?>
         

        </form>
    </div>
    
</body>
</html>

<?php
$hidden = isset($_POST["hidden"]) ? intval($_POST ["hidden"]) : 0;
$categoria = isset($_POST["categoria"]) ? $_POST ["categoria"] : "";


// Si se ha enviado el formulario, actualizamos el usuario
if ($hidden != 0 && $id > 0) {
    $sqlEdit = 'UPDATE categorias SET categoria = ? WHERE id = ?';
    $stmt = $conx->prepare($sqlEdit);
    $stmt->bind_param("si", $categoria,  $id);
    $stmt->execute();
    $stmt->close();
    
    header("Location: listadoCategorias.php");
    exit;
}

if ($hidden != 0 && $id == 0) {
    $sqlAgg = 'insert into categorias ( categoria ) values (?) ';
    $stmt = $conx->prepare($sqlAgg);
    $stmt->bind_param("s", $categoria);
    $stmt->execute();
    $stmt->close();
    
    header("Location: listadoCategorias.php");
    exit;
}

?>


