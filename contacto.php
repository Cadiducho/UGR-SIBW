<?php

require "core/Twig.php";
require "core/Database.php";
require "core/Core.php";

$database = new Database();
$core = new Core($twig, $database);

$contacto = $database->getContacto();

echo $core->render('contacto.twig', ["contacto" => $contacto]);


?>
