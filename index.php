<?php

require "core/Twig.php";
require "core/Database.php";

$database = new Database();

echo $twig->render('portada.twig', ["eventos" => $database->getEventosPortada()]);

?>
