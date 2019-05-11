<?php

require "../../Database.php";
$database = new Database();

$evento = $_POST['evento'] ?? "";
$nombre = $_POST['nombre'] ?? "";
$imagen = $_POST['imagen'] ?? "";
$organizador = $_POST['organizador'] ?? "";
$fecha = $_POST['fecha'] ?? "";
$descripcion = $_POST['descripcion'] ?? "";
$img1 = $_POST['imagen_lateral_1'] ?? "";
$img1desc = $_POST['imagen_lateral_1_descripcion'] ?? "";
$img2 = $_POST['imagen_lateral_2'] ?? "";
$img2desc = $_POST['imagen_lateral_2_descripcion'] ?? "";


if (empty($evento) || empty($nombre) || empty($imagen) || empty($organizador) || empty($fecha) || empty($descripcion) || empty($img1)
    || empty($img1desc) || empty($img2) || empty($img2desc)) {
  echo "error";
  return;
}

$database->editarEvento($evento, $nombre, $imagen, $organizador, $fecha, $descripcion, $img1, $img1desc, $img2, $img2desc);

echo "ok";




?>
