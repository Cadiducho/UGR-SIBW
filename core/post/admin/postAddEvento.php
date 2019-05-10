<?php

require "../../Database.php";
$database = new Database();

$nombreRegister = $_POST['nombre'] ?? "";
$imagenRegister = $_POST['imagen'] ?? "";
$organizadorRegister = $_POST['organizador'] ?? "";
$fechaRegister = $_POST['fecha'] ?? "";
$descripcionRegister = $_POST['descripcion'] ?? "";
$img1Register = $_POST['imagen_lateral_1'] ?? "";
$img1descRegister = $_POST['imagen_lateral_1_descripcion'] ?? "";
$img2Register = $_POST['imagen_lateral_2'] ?? "";
$img2descRegister = $_POST['imagen_lateral_2_descripcion'] ?? "";

if (empty($nombreRegister) || empty($imagenRegister) || empty($organizadorRegister) || empty($fechaRegister) || empty($descripcionRegister) || empty($img1Register)
    || empty($img1descRegister) || empty($img2Register) || empty($img2descRegister)) {
  echo "error";
  return;
}

$database->registrarEvento($nombreRegister, $imagenRegister, $organizadorRegister, $fechaRegister, $descripcionRegister, $img1Register, $img1descRegister, $img2Register, $img2descRegister);

echo "ok";


?>
