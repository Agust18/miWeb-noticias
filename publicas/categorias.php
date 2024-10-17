<?php
require_once("../db/db.php");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filtrar por Categoría</title>
</head>
<body>

    <h2>Filtrar Noticias por Categoría</h2>
    <div class="categoria">
        <form action="categorias.php" method="GET">
            <label for="categoria">Selecciona una categoría:</label>
            <select id="categoria" name="categoria">
                <option value="">--Seleccionar categoría--</option>
                <option value="tecnologia">Tecnología</option>
                <option value="deportes">Deportes</option>
                <option value="cultura">Cultura</option>
                <option value="politica">Política</option>
            </select>
            <br><br>
            <input type="submit" value="Buscar">
        </form>

    </div>
    
</body>
</html>


<?php
// Conexión a la base de datos


// Verificar si se seleccionó una categoría
$categoria = isset($_GET['categoria']) ? $_GET['categoria'] : '';

// Si hay una categoría seleccionada, filtrar por ella
if ($categoria) {
    $sql = "SELECT titulo,categoria FROM noticias WHERE categoria = :categoria";
    $stmt = $conx->prepare($sql);
    $stmt->bindParam("categoria", $categoria);
    $stmt->execute();
    $noticias = $stmt->fetchAll();
} else {
    // Si no se selecciona categoría, mostrar todos los resultados
    $sql = "SELECT titulo FROM noticias";
    $stmt =$conx->prepare($sql);
    $noticias = $stmt->fetchAll();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados Filtrados</title>
</head>
<body>

    <h2>Resultados de la Búsqueda</h2>
    
    <?php if ($noticias): ?>
        <ul>
            <?php foreach ($noticias as $noticia): ?>
                <li>
                    <h3><?php echo htmlspecialchars($noticia['titulo']); ?></h3>
                    <p><?php echo htmlspecialchars($noticia['contenido']); ?></p>
                    <small>Categoría: <?php echo htmlspecialchars($noticia['categoria']); ?></small>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No se encontraron resultados.</p>
    <?php endif; ?>

</body>
</html>