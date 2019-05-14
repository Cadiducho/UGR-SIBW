<?php

require "../../Database.php";
$database = new Database();

$evento = $_POST['evento'] ?? "";
$galeria = $_POST['galeria'] ?? "";

if (empty($evento) || empty($galeria)) {
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

$database->deleteGaleriaFromEvento($evento, $galeria);

echo "ok";

?>
