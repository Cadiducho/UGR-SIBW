<?php

require "core/Twig.php";
require "core/Database.php";

$database = new Database();
$idBuscada = $_GET['id'] ?? ""; //Si existe $_GET['id'] lo cojo, si no ""

$evento = $database->getEvento($idBuscada);
if ($evento != null) {
	echo $twig->render('eventoImprimir.twig', ["evento" => $evento]);
} else { // Si el evento no ha sido encontrado (quizás porque $id no era un número válido)
  echo $twig->render('eventoNotFound.twig');
}

?>
