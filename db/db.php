<?php
//para conectarnos necesitamos 
//SERVIDOR O IP , USUARIO , PASSWORD ,DATABASE.
<<<<<<< HEAD
$servidor = "utn-mysql"; // o 127.0.0.1
$usuario = "root"; 
$password = "password";
$database = "base";
=======
$servidor = "localhost"; // o 127.0.0.1
$usuario = "root"; 
$password = "";
$database = "noticias";
>>>>>>> 7343a80 (feat:segundo tp)

//Declarar conexion con mysqly 
//declarar los parametros en el mismo orden declarado arriba
$conx = new mysqli($servidor,$usuario,$password,$database);
//calcular un error
if ($conx->connect_error){
    echo "error: ".$conx->connect_error;

}
<<<<<<< HEAD



=======
>>>>>>> 7343a80 (feat:segundo tp)
?>