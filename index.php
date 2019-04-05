<?php

require "core/Twig.php";
require "core/Database.php";

$database = new Database();
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
echo $twig->render('portada.twig', ["eventos" => $eventos, "etiquetas" => $listaTags, "busqueda" => $busqueda]);

?>
