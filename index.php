<?php

require "core/Twig.php";
require "core/Database.php";
require "core/Core.php";

$database = new Database();
$core = new Core($twig, $database);

$tagBuscada = $_GET['tag'] ?? "";
$tagBuscada2 = $_GET['tag'] ?? "";

$eventos = array();
$busqueda = "";
if (empty($tagBuscada)) {
  $eventos = $database->getEventosPortada();
  $busqueda = "destacados";
} else {
  $eventos = $database->getEventosByNombreG($tagBuscada, $tagBuscada2);
  $busqueda = "por `" . $tagBuscada . "`";
}

$listaTags = $database->getTags();

echo $core->render('portada.twig', ["eventos" => $eventos, "etiquetas" => $listaTags, "busqueda" => $busqueda]);

?>
