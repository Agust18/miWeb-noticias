<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
//incluimos los archivos de conexion a la base de datos
require_once("../db/db.php");
require_once("../controllers/validar.php");
?>

<!-- <form action="" method = "POST">
    
    <input type="hidden" value="1" name="envio_formulario">
    <input type="text" name="nombre"  placeholder="nombre"><br>
    
   
   <br><textarea  type="text" rows="10" name="descripcion" placeholder="ingrese su descripcion"></textarea><br>
    
    <b><br><label for="">Ingrese su fecha de creacion</label></b>
    <br><input type="datetime-local" name="fecha" placeholder="fecha de creacion"><br>
    
    <br><input type="number" name="edad" placeholder="ingrese su edad"><br> 
    
    <br><input type="submit"><br>


</form> -->

<?php
//validamos si los datos existen
$id= isset($_GET["id"]) ? $_GET["id"] : 0 ; 
$nombre = isset($_POST["nombre"]) ? $_POST ["nombre"] : "";
$descripcion = isset($_POST["descripcion"])  ? $_POST ["descripcion"] : "";
$fecha_creacion = isset($POST["fecha"])  ? $_POST ["fecha"] : date("Y-m-d H:i:s");
$edad = isset($_POST["edad"]) ? $_POST ["edad"] : 0;
$hidden = isset($_POST["envio_formulario"]) ? $_POST ["envio_formulario"] : 0;

if ($hidden == "1") {
    $error=0;
    $mensaje= "";
    
    if (empty($nombre)){
        $error = 1;
        $mensaje = "porfavor ingrese su nombre";

    }

    if (empty($fecha_creacion) ){
        $error = 1;
        $mensaje = "Ingrese una fecha valida";
    }

    if (empty($descripcion)){
        $error = 1;
        $mensaje = "por favor ingrese una descripcion";
    }

    if (empty($edad)){
        $error = 1;
        $mensaje = "por favor ingrese su edad";
    }

    if ($error == 0){
        if ($id == 0) {				
            $sql = "INSERT INTO usuarios (nombre, fecha_creacion, descripcion, edad) VALUES (?, ?, ?, ?) ";
            $stmt = $conx->prepare($sql);
            $stmt->bind_param("sssi", $nombre, $fecha_creacion, $descripcion, $edad);
            $stmt->execute();
            $stmt->close();
        } else {
            $sql = "UPDATE usuarios SET nombre = ?, descripcion = ?, edad = ?  WHERE id = ? ";
            $stmt = $conx->prepare($sql);
            $stmt->bind_param("ssii", $nombre, $descripcion, $edad, $id);
            $stmt->execute();
            $stmt->close();
        }
        header("Location: listado.php");
        exit();
    } else {
        echo $mensaje;
    }

}

    $sql = "SELECT * FROM usuarios WHERE id = ? ";

	$stmt = $conx->prepare($sql);
	$stmt->bind_param("i", $id);
	$stmt->execute();

	$resultado = $stmt->get_result();

	$usuario = $resultado->fetch_object();

	$stmt->close();

	// No existe
	if ($usuario === null) {
		$id = 0;
		$nombre = "";
		$fecha_creacion = Date("Y-m-d H:i:s");
		$descripcion = "";
		$edad = 0;
	} else {
		$id = $usuario->id;
		$nombre = $usuario->nombre;
		$fecha_creacion = $usuario->fecha_creacion;
		$descripcion = $usuario->descripcion;
		$edad = $usuario->edad;
	}
?>


<h2>EDITE INFORMACION </h2>
<form method="POST">
	<input type="hidden" value="1" name="envio_formulario">

	<input type="hidden" name="id" value="<?php echo $id ?>">

	<label>Ingrese su nombre</label><br>
	<input type="text" value="<?php echo $nombre ?>" name="nombre"/>

	<?php if ($id == 0) { ?>
		<br><label>Fecha de creacion</label><br>
		<input type="datetime-local" value="<?php echo $fecha_creacion ?>" name="fecha_creacion">
	<?php } else { ?>
		<input type="hidden" value="<?php echo $fecha_creacion ?>" name="fecha_creacion">
	<?php } ?>

	<br><label>Descripcion</label><br>
	<textarea name="descripcion"  rows="5"><?php echo $descripcion ?></textarea>

	<br><label>Edad</label><br>
	<input type="number" value="<?php echo $edad ?>" name="edad">

	<input type="submit">
</form>


