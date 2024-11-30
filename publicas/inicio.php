<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
@session_start();
require_once("../db/db.php");
?>

<?php
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

<?php

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['id_categoria']) && $_POST['id_categoria'] != 0) {
    $id_categoria = intval($_POST['id_categoria']);

    // Consulta para filtrar noticias por la categoría seleccionada
    $sql = "SELECT * FROM NOTICIAS WHERE id_categoria = ? order by id desc";
    $stmt = $conx->prepare($sql);
    $stmt->bind_param("i", $id_categoria);
}elseif (isset($_GET['search']) && !empty($_GET['search'])) {
    $search = $_GET['search'];
    $search_param = "%" . $search . "%";
    $sql = "SELECT * FROM NOTICIAS WHERE titulo LIKE ? ORDER BY id DESC";
    $stmt = $conx->prepare($sql);
    $stmt->bind_param("s", $search_param);
} else{
    // Consulta para obtener todas las noticias si no se seleccionó una categoría
    $sql = "SELECT * FROM NOTICIAS order by id desc";
    $stmt = $conx->prepare($sql);
} 



$stmt->execute();
$resultado = $stmt->get_result();
$FinalResultado = [];
while ($fila = $resultado->fetch_object()){
    $FinalResultado[] = $fila;
}
$stmt->close();




 

 
// $sql = ("SELECT * FROM NOTICIAS");
// $stmt = $conx->prepare($sql);
// $stmt->execute();
// $resultado = $stmt->get_result();
// $FinalResultado = [];
// while ($fila = $resultado->fetch_object()){
//     $FinalResultado[] = $fila; 
// }
// $stmt->close();







// if(isset($_POST['id_categoria']) && $_POST['id_categoria'] != 0){
//     $sql = "SELECT N.id,N.titulo,N.imagen FROM NOTICIAS N INNER JOIN CATEGORIAS C ON (N.ID_CATEGORIA=C.ID) WHERE C.ID = ?";
//     $stmt = $conx->prepare($sql);
//     $stmt->bind_param( "i", $id_categoria);
//     $stmt->execute();
//     $resultadoG = $stmt->get_result();
//     $resultadoFinalG = [];
//     while ($filaFiltro = $resultadoG->fetch_object()){
//         $resultadoFinalG[] = $filaFiltro;

//     }
//     $stmt->close();

// }


    

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

                <form method="GET" action="" class="buscador">
                    <input type="text" name="search" placeholder="search">
                    <input type="submit" value="buscar">
                </form>

                             
                <li><a href="../privadas/agregarNoticia.php">agregarNoticia</a></li>
                <?php
                if (isset($_SESSION["id"])|| !empty($_SESSION["id"])){ ?>
                    <li>
                        <form action="../controles/cerrarUser.php" method="POST">
                            <input type="submit"  value="cerrar session">
                        </form>
                
                    </li>
                    <?php }?> 

            </ul> 
        </nav>
    </div>
</header>
                

    <input type="hidden" name="filtro" value="1">
    <div class="categoria">
        <form action="" method="POST">
            <label for="categoria">Filtrar categoria:</label>
            <select name="id_categoria" id="categoria" class="form-select" onchange="this.form.submit()"> //captura 
                <option value="0">seleccionar</option>
                    <?php foreach ($resultadoFinal as $categoria) { ?>
                <option value="<?php echo $categoria->id; ?>" >
                    <?php echo $categoria->categoria;?>
                </option>
              <?php } ?>
            </select>
           
            <br><br>
            <input type="submit" value="filtrar">
        </form>

    </div>
    


<div class="contenedor"> 
    <?php foreach ($FinalResultado as $noticia) { ?>
        <div class="titulo1">
            <h3><?php echo $noticia->titulo; ?></h3>
            <img src="<?php echo $noticia->imagen ?>">
             <!-- Aquí pasamos el ID de la noticia en el enlace -->
            <a href="detalles.php?id=<?php echo $noticia->id; ?>">Ver más</a>
        </div>
    <?php
    } ?>
</div>
      
  



<footer>
    <div class="footer-section">
        <ul>
        <li><a href="/about-us">Acerca de Nosotros</a></li>
        <li><a href="/privacy-policy">Política de Privacidad</a></li>
        <li><a href="/terms-conditions">Términos y Condiciones</a></li>
        <li><a href="/contact">Contáctanos</a></li>
        </ul>
    </div>
    <div class="footer-section">
        <ul>
            <li><a href="https://facebook.com" target="_blank">Facebook</a></li>
            <li><a href="https://twitter.com" target="_blank">Twitter</a></li>
            <li><a href="https://instagram.com" target="_blank">Instagram</a></li>
        </ul>
    </div>
</footer>

</body>
</html>




