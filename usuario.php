<?php

require "core/Twig.php";
require "core/Database.php";
require "core/Core.php";

$database = new Database();
$core = new Core($twig, $database);

$updated = $_GET['updated'] ?? "";

echo $core->render('usuario.twig', ["updated" => $updated]);

?>
