<?php

require "core/Twig.php";
require "core/Database.php";

$database = new Database();
$idBuscada = $_GET['id'] ?? ""; //Si existe $_GET['id'] lo cojo, si no ""

$evento = $database->getEvento($idBuscada);
if ($evento != null) {
  $comentarios = $database->getComentariosEvento($evento->id);
  $tags = $database->getTagsOfEvent($evento->id);
  $galeria = $database->getGaleriaEvento($evento->id);
  $prohibidas = $database->getPalabrasProhibidas();
  echo $twig->render('evento.twig', ["evento" => $evento, "comentarios" => $comentarios, "etiquetas" => $tags, "galeria" => $galeria, "prohibidas" => $prohibidas]);
} else { // Si el evento no ha sido encontrado (quizás porque $id no era un número válido)
  echo $twig->render('eventoNotFound.twig');
}

?>
