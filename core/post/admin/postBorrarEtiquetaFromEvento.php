<?php

require "../../Database.php";
$database = new Database();

$evento = $_POST['evento'] ?? "";
$etiqueta = $_POST['etiqueta'] ?? "";

if (empty($evento) || empty($etiqueta)) {
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

$database->deleteEtiquetaFromEvento($evento, $etiqueta);

echo "ok";

?>
