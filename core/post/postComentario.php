<?php

require "../Database.php";
$database = new Database();

session_start();

$evento = $_POST['evento'] ?? "";
$userid = $_POST['userid'] ?? "";
$texto = $_POST['texto'] ?? "";
$fecha = $_POST['fecha'] ?? "";

if (empty($evento) || empty($userid) || empty($texto) || empty($fecha)) {
    echo "error";
} else {
    $realUserId = $_SESSION["loggedUserId"] ?? "";
    if ($realUserId != $userid) {
        echo "error"; //Usuario no autorizado
    } else {
        $fecha = date("Y-m-d H:i:s");
        $ip = isset($_SERVER['HTTP_CLIENT_IP']) ? $_SERVER['HTTP_CLIENT_IP'] : isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];
        $database->insertarComentario($evento, $userid, $texto, $fecha, $ip);
    }
}

?>
