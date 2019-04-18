<?php

require "core/Twig.php";
require "core/Database.php";

$database = new Database();

$contacto = $database->getContacto();

echo $twig->render('contacto.twig', ["contacto" => $contacto]);


?>
