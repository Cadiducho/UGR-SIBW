<?php

require "core/Twig.php";
require "core/Database.php";
require "core/Core.php";

$database = new Database();
$core = new Core($twig, $database);

$idBuscada = $_GET['id'] ?? ""; //Si existe $_GET['id'] lo cojo, si no ""

$evento = $database->getEvento($idBuscada);
if ($evento != null) {
  $comentarios = $database->getComentariosEvento($evento->id);
  $tags = $database->getTagsOfEvent($evento->id);
  $evento->etiquetas = $tags;
  $galeria = $database->getGaleriaEvento($evento->id);
  $evento->galeria = $galeria;
  $prohibidas = $database->getPalabrasProhibidas();
  echo $core->render('evento.twig', ["evento" => $evento, "comentarios" => $comentarios, "prohibidas" => $prohibidas]);
} else { // Si el evento no ha sido encontrado (quizás porque $id no era un número válido)
  echo $core->render('eventoNotFound.twig');
}

?>
