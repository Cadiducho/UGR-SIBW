<?php

require "../../Database.php";
$database = new Database();

$comentario = $_POST['comentario'] ?? "";
$mensaje = $_POST['mensaje'] ?? "";

if (empty($comentario) || empty($mensaje)) {
    echo "error";
    return;
}

session_start();

$adminid = $_SESSION["loggedUserId"] ?? "";
$adminUser = $database->getUsuarioById($adminid);
if (is_null($adminUser) || $adminUser->rango < Usuario::MODERADOR) {
  echo "unauthorized";
  return;
}

$database->editComentario($comentario, $mensaje, $adminid);

echo "ok";

?>
