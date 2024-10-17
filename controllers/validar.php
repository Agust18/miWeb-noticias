<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

@session_start();
//para validar por incorrecto usamos or ||
if (!isset($_SESSION["id"]) || empty($_SESSION["id"])) {
    //no estoy validado
    header("Location: ../views/login.php");
    exit();

} 




?>