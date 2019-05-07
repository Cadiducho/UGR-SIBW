<?php

require "core/Twig.php";
require "core/Database.php";
require "core/Core.php";

$database = new Database();
$core = new Core($twig, $database);

$updated = $_GET['updated'] ?? "";

session_start();
$userBuscado = $database->getUsuarioById($_SESSION["loggedUserId"]);

if($userBuscado == NULL)
  header("Location: ../../index.php");
else
  echo $core->render('usuario.twig', ["updated" => $updated]);
?>
