<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once("../db/db.php");
// require_once("../controles/validarUser.php");

@session_start();
//para validar por incorrecto usamos or ||
if (!isset($_SESSION["id"]) || empty($_SESSION["id"])) {
    //no estoy validado
    header("Location: loginUsuario.php");
    exit();
}
//consulta para traer todas las categorias
//ponerlas en un array 
// $sql=("SELECT * FROM categorias ");
//     $stmt=$conx->prepare($sql);
//     $stmt->execute();
//     $resultadoStmt=$stmt->get_result();
//     $resultado=$resultadoStmt->fetch_object();
//      // Inicializamos el array de categorías
//     $categorias = [$resultado];
//     // $categorias[] = $resultado->categoria;
//     print_r($categorias)

$sql = ("select * from categorias");
$stmt = $conx->prepare($sql);
$stmt->execute();
$resultado = $stmt->get_result();
$resultadoFinal = [];
while ($fila = $resultado->fetch_object()){
    $resultadoFinal[] = $fila;
}
$stmt->close();


   

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/header.css">
    <link rel="stylesheet" href="../styles/agregarNoticia.css">
    <title>Document</title>
  
</head>
<body>
    <header>
    <h2 >Agregar Noticia</H2>
    
    <nav class="nav-links">
            <ul>
                <li><a href="../publicas/inicio.php">Inicio</a></li>
               
                <li><a href="agregarNoticia.php">Agregar noticia</a></li>
                <?php
                if (isset($_SESSION["id"])|| !empty($_SESSION["id"])){ ?>
                    <li>
                        <form action="../controles/cerrarUser.php" method="POST">
                            <input type="submit"  value="cerrar session">
                        </form>
                
                    </li>
                    <?php }?> 
               
            </ul> 
       </header>

       
  
   
<div class="formu">
        <form action="agregarNoticia.php" method="POST" enctype="multipart/form-data">
            <div class="titulo">
                <p>Titulo de la noticia</p>
                <input type="text" name="titulo" placeholder="Title Notice" >
            </div>
            <input type="hidden" value="1" name="hidden">

            <div class="descripcion">
                <p>Descripcion de noticia</p>
                <textarea 
                type="text" rows="60"  name="descripcion" placeholder="Description" >
                </textarea>

            </div>

            <textarea name="texto" placeholder="texto" rows="60" id=""></textarea>
         
           
            <!-- <label for="categoria">Selecciona una categoría:</label> -->
            <select name="id_categoria" id="categoria" class="form-select">
            
              <?php foreach ($resultadoFinal as $categoria) { ?>
                <option value="<?php echo $categoria->id; ?>" >
                  <?php echo $categoria->categoria;?>
                </option>
              <?php } ?>
            </select>
            
           
            
          

            
             <div class="file">
                <p>Selecciona imagen</p>
                <input type="file" name="imagen"><br> 

            </div> 
            <div class="buton">
                <input type="submit" class="buton" value="enviar">
            </div>

        </form>
</div>
    
</body>

</html>

<?php

$imagen = isset($_POST["imagen"]) ? $_POST ["imagen"] : "";
$titulo = isset($_POST["titulo"]) ? $_POST ["titulo"] : "";
$descripcion = isset($_POST["descripcion"]) ? $_POST ["descripcion"] : "";
$id_categoria = isset($_POST["id_categoria"]) ? $_POST ["id_categoria"] : "";
$hidden = isset($_POST["hidden"]) ? $_POST ["hidden"] : "";
$texto = isset($_POST["texto"]) ? $_POST ["texto"] : "";


?>

<?php 

if ($hidden == 1) {
    $error = 0;
    $mensaje = "";

    if (empty($titulo)) {
        $error = 1;
        $mensaje .= "Por favor ingrese un título para la noticia.<br>";
    }
    if (empty($descripcion)) {
        $error = 1;
        $mensaje .= "Por favor ingrese una descripción.<br>";
    }
    if (empty($categoria)) {
        $error = 1;
        $mensaje .= "Por favor ingrese una categoría.<br>";
    }
    if (empty($texto)) {
        $error = 1;
        $mensaje .= "Por favor ingrese el texto de la noticia.<br>";
    }
    
    //Verificar si se ha subido un archivo
    // Comprobar si se ha subido el archivo
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === 0) {
        // Obtener información del archivo
        $archivo = $_FILES['imagen'];
        $nombreArchivo = basename($archivo['name']);
        $rutaDirectorio = '../uploads/'; // Directorio donde se guardarán las imágenes
        $rutaCompleta = $rutaDirectorio . $nombreArchivo;

            // Mover el archivo subido a la carpeta 'uploads'
    if (move_uploaded_file($archivo['tmp_name'], $rutaCompleta)) {
        echo "//Archivo subido correctamente";
        $rutaFinal = $rutaCompleta; 
        
        
       
    } else{
        echo "error al cargar la imagen";
        exit();
    }
    }

    // // Asegúrate de que el directorio existe
    // if (!is_dir($rutaDirectorio)) {
    //     mkdir($rutaDirectorio, 0777, true); // Crea el directorio si no existe
    // }

    
   

    if ($error == 0){
        $sql = "INSERT INTO noticias (titulo, descripcion, texto, imagen,id_categoria ) VALUES (?, ?, ?, ?,?)";
        $stmt = $conx->prepare($sql);
        $stmt->bind_param("ssssi",$titulo, $descripcion,$texto, $rutaFinal,$id_categoria);
        $stmt->execute();
        $stmt->close();
        header("Location: ../privadas/mensajeUser.php");
        exit();
    }else {
        echo $mensaje;
    }
   
   
    

}  





?>