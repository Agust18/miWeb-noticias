<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once("../db/db.php");
require_once("validar.php");

$id = isset($_POST["id"]) ? $_POST ["id"] : 0;
//dato controlado es un dato que tiene siempre el mismo valor
$stmt = $conx -> prepare("UPDATE usuarios SET eliminado = 1 where id = ?");
$stmt-> bind_param("i",$id);
$stmt->execute();
$stmt->close();
header("Location: ../views/listado.php");
exit();



?>