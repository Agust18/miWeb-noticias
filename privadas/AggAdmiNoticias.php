<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once("../db/db.php");

// Consulta para obtener todas las categorías disponibles
$sqlCategorias = "SELECT id, categoria FROM categorias";
$resultadoCategorias = $conx->query($sqlCategorias);
$categorias = [];
while ($fila = $resultadoCategorias->fetch_object()) {
    $categorias[] = $fila;
}

// Verifica si se recibe el id de la noticia para editar, o 0 si es una nueva noticia
$id = isset($_GET["id"]) ? (int)$_GET["id"] : 0;
var_dump($id);
if ($id != 0) {
    // Consulta para obtener la noticia por su ID
    $sql = "select * FROM noticias n inner join categorias c  on (n.id_categoria=c.id)  WHERE c.id = ?";
    $stmt = $conx->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $resultadoStmt = $stmt->get_result();
    
    $resultado = $resultadoStmt->fetch_object();

    // Se obtienen los datos de la noticia para mostrarlos en el formulario de edición
    $titulo = $resultado->titulo;
    $descripcion = $resultado->descripcion;
    $imagen = $resultado->imagen;
    $texto = $resultado->texto;
    $id_categoria = $resultado->id_categoria;
} else {
    // Campos vacíos para una nueva noticia
    $titulo = "";
    $descripcion = "";
    $imagen = "";
    $texto = "";
    $id_categoria = 0;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/header.css">    
    <link rel="stylesheet" href="../styles/listado.css">
    <title>Editar Noticia</title>
</head>
<header>
    <h2>Administrador de Noticias</h2>
    <nav class="nav-links">
        <ul>
            <li><a href="listado.php">Usuarios</a></li>
            <li><a href="listadoNoticias.php">Noticias</a></li>
            <li><a href="listadoCategorias.php">Categorías</a></li>
        </ul>
    </nav>
</header>

<body>
    <div class="listadosub">
        <h2><?php echo $id != 0 ? "Editar Noticia" : "Agregar Noticia"; ?></h2>
    </div>
    
    <!-- Formulario para agregar o editar noticia -->
    <div class="formu">
        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="hidden" value="1"> 
            <?php if ($id != 0) { ?>
                <input type="hidden" name="id" value="<?php echo $id ?>">
            <?php } ?>
            
            <!-- Campos para la noticia -->
            <input type="text" name="titulo" placeholder="Título" value="<?php echo $titulo ?>" required>
            <textarea name="descripcion" placeholder="Descripción" required><?php echo $descripcion ?></textarea>
            <textarea name="texto" placeholder="Texto de la noticia" required><?php echo $texto ?></textarea>
            
            <!-- Campo de selección de categoría -->
            <select name="id_categoria" required>
                <option value="">Seleccione una categoría</option>
                <?php foreach ($categorias as $categoria) { ?>
                    <option value="<?php echo $categoria->id; ?>" <?php if ($categoria->id == $id_categoria) echo 'selected'; ?>>
                        <?php echo $categoria->categoria; ?>
                    </option>
                <?php } ?>
            </select>
            
            <!-- Campo de imagen -->
            <input type="file" name="imagen">
            <?php if (!empty($imagen)) { ?>
                <p>Imagen actual: <?php echo $imagen; ?></p>
            <?php } ?>

            <!-- Botón para enviar formulario -->
            <input type="submit" value="<?php echo $id != 0 ? "Editar" : "Agregar"; ?>">
        </form>
    </div>

    <!-- Botón de cierre de sesión -->
    <div class="listadoformulario">
        <form action="../controles/cerrarAdmi.php" method="POST">
            <input type="submit" value="Cerrar sesión">
        </form>
    </div>
</body>
</html>

<?php
$hidden = isset($_POST["hidden"]) ? intval($_POST["hidden"]) : 0;
$titulo = isset($_POST["titulo"]) ? $_POST["titulo"] : "";
$descripcion = isset($_POST["descripcion"]) ? $_POST["descripcion"] : "";
$texto = isset($_POST["texto"]) ? $_POST["texto"] : "";
$id_categoria = isset($_POST["id_categoria"]) ? intval($_POST["id_categoria"]) : 0;

// Si el formulario fue enviado, procesa la imagen y guarda la noticia
if ($hidden != 0) {
    // Procesar la imagen subida, si es necesario
    // Procesar la imagen subida, si es necesario
    $imagen_path = $imagen;  // Si no hay imagen nueva, se conserva la antigua
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == UPLOAD_ERR_OK) {
        $imagen_path = "../uploads/" . basename($_FILES['imagen']['name']);  // Directorio de destino
        // Mover la imagen al directorio de "uploads"
        move_uploaded_file($_FILES['imagen']['tmp_name'], $imagen_path);
    }

    if ($id > 0) {
        // Actualización de la noticia existente
        $sqlEdit = 'UPDATE noticias SET titulo = ?, descripcion = ?, texto = ?, id_categoria = ?, imagen = ? WHERE id = ?';
        $stmt = $conx->prepare($sqlEdit);
        $stmt->bind_param("sssisi", $titulo, $descripcion, $texto, $id_categoria, $imagen_path, $id);
    } else {
        // Inserción de una nueva noticia
        $sqlAgg = 'INSERT INTO noticias (titulo, descripcion, texto, id_categoria, imagen) VALUES (?, ?, ?, ?, ?)';
        $stmt = $conx->prepare($sqlAgg);
        $stmt->bind_param("sssis", $titulo, $descripcion, $texto, $id_categoria, $imagen_path);
    }

    $stmt->execute();
    $stmt->close();
    
    header("Location: listadoNoticias.php");
    exit;
}
?>
