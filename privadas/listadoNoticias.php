<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//importar la conexion: 
//include
//include_once para archivos no necesarios
//el include php envia un mensaje de error pero no frena el codigo 
//require
//require_once
//mata el codigo 
require_once("../db/db.php");
 require_once("../controles/validarAdmi.php");
// $edad = isset($_GET["edad"]) ? $_GET["edad"] : 0;
//query ejecuta a la misma vez que ingresamos los datos
//stmt (statement) primero ejecuta la consulta y despues ingresa los datos
//TRABAJAMOS CON STATEMENT SIEMPRE
// paso1 : preparar la consulta con stmt 
//stmt para evitar inyecciones de consultas
$stmt = $conx->prepare("SELECT * FROM noticias N inner join categorias C on (N.id_categoria=C.id)");

// paso 1.5
//enteros = i
//decimales = d
//strings = s
//$stmt->bind_params("is",$edad,$nombre);
//$stmt->bind_param("i",$edad);
//paso 2: ejecutar la consulta
$stmt->execute();
//si estamos trabahjando con un Select, guardamos los resultados
//en una variable
// Si estamos trabajando con un select...
$resultadoSTMT = $stmt->get_result(); //valores generales de la consulta

$nuestroResultado = []; //valores que vamos a trabajar
//fila es cada uno de los resultados que tengo 

while ($fila  = $resultadoSTMT -> fetch_object()){
    //fetch_object
	//fetch_assoc
	//fetch_array
    //agragamos cada valor de fila al array de la variable nuestroResultado
    $nuestroResultado[] = $fila;
}
$stmt->close();
// foreach ($nuestroResultado as $fila){
//     echo $fila->nombre."<br>";
// }

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
                <li><a href="AggAdmiNoticias.php">Agregar Noticias </a></li>
               

            </ul> 
        </nav>
    </div>
</header>


<body>
    <div class="listadosub">
         <h2>LISTADO DE NOTICIAS</h2>
    </div>
    <div class="table">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Titulo</th>
                    <th>Categoria</th>
                    <th>Texto</th>
                    <th>Descripción</th>
                    <th>Imagen</th>
                  
                   
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($nuestroResultado as $fila) { ?>
                <tr>
                    <td><?php echo $fila->id ?></td>
                    <td><?php echo $fila->titulo ?></td>
                    <td><?php echo $fila->categoria ?></td>
                    <td><?php echo $fila->texto ?></td>
                    <td><?php echo $fila->descripcion ?></td>
                    <div class="listadoNoticiasImagen">
                    <td><img class="listado-img" src="<?php echo $fila->imagen ?>" /></td>

                    </div>
                   
                  
                    
                    
                    <td>
                        <a href="AggAdmiNoticias.php?id=<?php echo $fila->id ?>">Editar</a>
                        <form action="../controles/eliminarNoticias.php" method="POST">
                            <input type="hidden" value="<?php echo $fila->id ?>" name="id">
                            <input type="submit" value="eliminar">
                        </form>
                    </td>

                
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
   
    <div class="listadoformulario">
        <form action="../controles/cerrarAdmi.php" method="POST">
            <input type="submit"  value="cerrar session">
        </form>
    </div>


  
</body>
</html>