<?php

require "../../Database.php";
$database = new Database();

$comentario = $_POST['comentario'] ?? "";

if (empty($comentario)) {
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

$database->deleteComentario($comentario);

echo "ok";

?>
