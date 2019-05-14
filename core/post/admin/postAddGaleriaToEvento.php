<?php

require "../../Database.php";
$database = new Database();

$evento = $_POST['evento'] ?? "";
$imagen = $_POST['imagen'] ?? "";
$descripcion = $_POST['descripcion'] ?? "";

if (empty($evento) || empty($imagen) || empty($descripcion)) {
    echo "error";
    return;
}

session_start();

$adminid = $_SESSION["loggedUserId"] ?? "";
$adminUser = $database->getUsuarioById($adminid);
if (is_null($adminUser) || $adminUser->rango < Usuario::GESTOR) {
  echo "unauthorized";
  return;
}

$database->addImageToEvent($evento, $imagen, $descripcion);

echo "ok";

?>
