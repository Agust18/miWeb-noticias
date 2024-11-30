<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
@session_start();
require_once("../db/db.php");
?>

<?php
$FinalResultado = [];

// Comprobar si hay búsqueda por título
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search = $_GET['search'];
    $search_param = "%" . $search . "%";

    $sql = "SELECT * FROM NOTICIAS WHERE titulo LIKE ? ORDER BY id DESC";
    $stmt = $conx->prepare($sql);
    $stmt->bind_param("s", $search_param);
}
// Comprobar si hay filtro de categoría
elseif ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['id_categoria']) && $_POST['id_categoria'] != 0) {
    $id_categoria = intval($_POST['id_categoria']);

    $sql = "SELECT * FROM NOTICIAS WHERE id_categoria = ? ORDER BY id DESC";
    $stmt = $conx->prepare($sql);
    $stmt->bind_param("i", $id_categoria);
} else {
    // Si no hay búsqueda ni filtro, obtener todas las noticias
    $sql = "SELECT * FROM NOTICIAS ORDER BY id DESC";
    $stmt = $conx->prepare($sql);
}

$stmt->execute();
$resultado = $stmt->get_result();
while ($fila = $resultado->fetch_object()) {
    $FinalResultado[] = $fila;
}
$stmt->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/header.css"> 
    <link rel="stylesheet" href="../styles/inicio.css"> 
    <link rel="stylesheet" href="../styles/footer.css"> 
    <title>Document</title>
</head>
<body>
<header>
    <h1>ENTERATE!</h1>
    <div>
       <nav class="nav-links">
            <ul>
                <li><a href="inicio.php">Inicio</a></li>

                <!-- Formulario de búsqueda -->
                <form class="buscador" method="GET" action="">
                    <input type="text" name="search" placeholder="Buscar por título...">
                    <input type="submit" value="Buscar">
                </form>
                             
                <li><a href="../privadas/agregarNoticia.php">Agregar Noticia</a></li>
                <?php if (isset($_SESSION["id"]) || !empty($_SESSION["id"])) { ?>
                    <li>
                        <form action="../controles/cerrarUser.php" method="POST">
                            <input type="submit" value="Cerrar sesión">
                        </form>
                    </li>
                <?php } ?> 
            </ul> 
        </nav>
    </div>
</header>

<div class="categoria">
    <form action="" method="POST">
        <label for="categoria">Filtrar por categoría:</label>
        <select name="id_categoria" id="categoria" class="form-select" onchange="this.form.submit()">
            <option value="0">Selecciona una categoría</option>
            <?php foreach ($resultadoFinal as $categoria) { ?>
                <option value="<?php echo $categoria->id; ?>">
                    <?php echo $categoria->categoria; ?>
                </option>
            <?php } ?>
        </select>
        <input type="hidden" name="filtro" value="1">
    </form>
</div>

<div class="contenedor"> 
    <?php foreach ($FinalResultado as $noticia) { ?>
        <div class="titulo1">
            <h3><?php echo $noticia->titulo; ?></h3>
            <img src="<?php echo $noticia->imagen ?>">
            <a href="detalles.php?id=<?php echo $noticia->id; ?>">Ver más</a>
        </div>
    <?php } ?>
</div>

</body>
</html>

