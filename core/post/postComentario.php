<?php

require "../Database.php";
$database = new Database();

$evento = $_POST['evento'] ?? "";
$nombre = $_POST['nombre'] ?? "";
$email = $_POST['email'] ?? "";
$texto = $_POST['texto'] ?? "";
$fecha = $_POST['fecha'] ?? "";

if (empty($evento) || empty($nombre) || empty($email) || empty($texto) || empty($fecha)) {
  echo "error";
} else {
  $fecha = date("Y-m-d H:i:s");
  $ip = isset($_SERVER['HTTP_CLIENT_IP']) ? $_SERVER['HTTP_CLIENT_IP'] : isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];
  $database->insertarComentario($evento, $nombre, $email, $texto, $fecha, $ip);
}

?>
