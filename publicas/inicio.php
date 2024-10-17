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
// $filtro =  isset($_POST["filtro"]) ? $_POST ["filtro"] : "";
// $id_categoria =  isset($_POST["id_categoria"]) ? $_POST ["id_categoria"] : 0;

// if ($id_categoria == 0 || $filtro == 0){
//     $sql = ("SELECT * FROM NOTICIAS");
//     $stmt = $conx->prepare($sql);
//     $stmt->execute();
//     $resultado = $stmt->get_result();
//     $resultadoFinal = [];
//     while ($fila = $resultado->fetch_object()){
//         $resultadoFinal[] = $fila; 
//     }
//     $stmt->close();

    
// } else{
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
    <h1>what happens?</h1>
    <div>
       <nav class="nav-links">
            <ul>
                <li><a href="inicio.php">Inicio</a></li>
                <li><a href="categorias.php">Categorias</a></li>
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
              <option value="0">selecciona</option>
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
        <div class="titulo1">
        <h3>titulo1</h3>
        <img src="../uploads/demon_slayer_obanai_iguro_with_a_zigzag_sword_with_background_of_purple_hd_anime-1920x1080.jpg" alt="Imagen 1">
        <a href="detalles.php">ver mas</a>
    </div>
    <div class="titulo2">
        <h3>titulo2</h3>
        <img src="../uploads/thumb-1920-1020808.jpg" alt="Imagen 2">
        <a href="">ver mas</a>
    </div>
    <div class="titulo3">
        <h3>titulo3</h3>
        <img src="../uploads/descarga (2).jfif" alt="Imagen 2">
        <a href="">ver mas</a>
    </div>
</div>

<div class="contenedor2">
    <div class="titulo4">
        <h3>titulo4</h3>
        <img src="../uploads/descarga (3).jfif" alt="Imagen 1">
        <a href="http://">ver mas</a>
    </div>
    <div class="titulo5">
        <h3>titulo5</h3>
        <img src="../uploads/⚠︎︎ᴍɪᴋᴇʏ.jfif" alt="Imagen 2">
        <a href="http://">ver mas</a>
    </div>
    <div class="titulo6">
        <h3>titulo6</h3>
        <img src="" alt="Imagen 2">
        <a href="http://">ver mas</a>
    </div>
</div>

<div class="contenedor3">
    <div class="titulo7">
        <h3>titulo7</h3>
        <img src="" alt="Imagen 1">
        <a href="http://">ver mas</a>
    </div>
    <div class="titulo8">
        <h3>titulo8</h3>
        <img src="" alt="Imagen 2">
        <a href="http://">ver mas</a>
    </div>
    <div class="titulo9">
        <h3>titulo9</h3>
        <img src="" alt="Imagen 2">
        <a href="">ver mas</a>
    </div>
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

<?php


