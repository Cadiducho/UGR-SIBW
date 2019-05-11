<?php

require "../../Database.php";
$database = new Database();

$evento = $_POST['evento'] ?? "";

if (empty($evento)) {
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

$database->deleteEvento($evento);

echo "ok";

?>
