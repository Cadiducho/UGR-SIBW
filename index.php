<?php

require "core/Twig.php";
require "core/Database.php";
require "core/Session.php";

$database = new Database();
$session = new Session($twig, $database);

$tagBuscada = $_GET['tag'] ?? "";

$eventos = array();
$busqueda = "";
if (empty($tagBuscada)) {
  $eventos = $database->getEventosPortada();
  $busqueda = "destacados";
} else {
  $eventos = $database->getEventosByTag($tagBuscada);
  $busqueda = "por `" . $tagBuscada . "`";
}

$listaTags = $database->getTags();

echo $session->render('portada.twig', ["eventos" => $eventos, "etiquetas" => $listaTags, "busqueda" => $busqueda]);

?>
