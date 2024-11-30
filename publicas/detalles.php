<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
 require_once("../db/db.php");
?>
<?php
$id= isset($_GET["id"]) ? $_GET["id"] : 0 ; 

$sql = ("SELECT * FROM NOTICIAS where id = ?");
$stmt = $conx->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$resultado = $stmt->get_result();
$resultadoFinal = [];
while ($fila = $resultado->fetch_object()){
    $FinalResultado[] = $fila; 

    
}
$stmt->close();

// Consulta para obtener la noticia principal
$sql = "SELECT * FROM NOTICIAS WHERE id = ?";
$stmt = $conx->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$resultado = $stmt->get_result();
$noticiaPrincipal = $resultado->fetch_object(); // Obtén la noticia principal

// Verifica si se encontró la noticia principal
if (!$noticiaPrincipal) {
    echo "<p>La noticia no existe o no se ha encontrado.</p>";
    exit;
}

$stmt->close();

// Obtener el ID de la categoría de la noticia principal
$id_categoria = $noticiaPrincipal->id_categoria;  // Ajustamos a "id_categoria"

// Consulta para obtener las noticias relacionadas, que sean de la misma categoría, excluyendo la noticia principal
$sqlRelacionadas = "SELECT * FROM NOTICIAS WHERE id_categoria = ? AND id != ? LIMIT 6";
$stmtRelacionadas = $conx->prepare($sqlRelacionadas);
$stmtRelacionadas->bind_param("ii", $id_categoria, $id);
$stmtRelacionadas->execute();
$resultadoRelacionadas = $stmtRelacionadas->get_result();

// Guardar las noticias relacionadas en un array
$noticiasRelacionadas = [];
while ($fila = $resultadoRelacionadas->fetch_object()) {
    $noticiasRelacionadas[] = $fila;
}

$stmtRelacionadas->close();






?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/header.css">
    <link rel="stylesheet" href="../styles/detalles.css">
   
    <title>Document</title>
</head>
<body>
    <header>
        <h2>ENTERATE!</h2>
        <div>
        <nav class="nav-links">
                <ul>
                    <li><a href="inicio.php">Inicio</a></li>
                    
                    <li><a href="../privadas/agregarNoticia.php">Agregar Noticia</a></li>
                    
                </ul> 
            </nav>
        </div>
    </header>
    <div class="contenedor">
            <?php foreach ($FinalResultado as $noticia) { ?>
                <div class="titulo">
                    <h3 class="titulod"><?php echo $noticia->titulo; ?></h3>
                    <img src="<?php echo $noticia->imagen?>">
                    <p><?php echo $noticia->descripcion ?></p>
                    <p><?php echo $noticia->texto ?></p>
                </div>
            <?php
        } ?>
    </div>
    
    <div class="relacionadas">
        <p class="p-body">NOTICIAS RELACIONADAS</p>
        <div class="galeria-relacionadas">
            <?php foreach ($noticiasRelacionadas as $noticia) { ?>
                <div class="noticia-relacionada">
                    <div class="titulo">
                        <h5><?php echo $noticia->titulo; ?></h5> <!-- Título de la noticia relacionada -->
                    </div>
                    <div class="img-relacion">
                        <img src="<?php echo $noticia->imagen; ?>" alt="Imagen de noticia relacionada"> <!-- Imagen de la noticia relacionada -->
                        
                    </div>
                    <a href="detalles.php?id=<?php echo $noticia->id; ?>">Ver mas</a> <!-- Enlace a los detalles de la noticia relacionada -->
                    
                    
                   
                   
                </div>
            <?php } ?>
        </div>
    </div>
   


   
    
    
</body>
</html>