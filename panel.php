<?php

require "core/Twig.php";
require "core/Database.php";
require "core/Core.php";

$database = new Database();
$core = new Core($twig, $database);

$loggedUser = $database->getUsuarioById($_SESSION["loggedUserId"]);

if ($loggedUser == NULL) {
  header("Location: ../../index.php");
  return;
} else if ($loggedUser->rango < Usuario::MODERADOR) {
  header("Location: ../../index.php");
  return;
}


$parametros = array();

if ($loggedUser->rango >= Usuario::MODERADOR) {
    $parametros["comentarios"] = $database->getAllComentarios();
    $parametros["usuarios"] = $database->getAllUsuarios();
}
echo $core->render('admin/panel.twig', $parametros);
?>
