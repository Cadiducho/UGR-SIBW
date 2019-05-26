<?php

require "core/Twig.php";
require "core/Database.php";
require "core/Core.php";

$database = new Database();
$core = new Core($twig, $database);

$tagBuscada = $_GET["q"];
$tagBuscada2 = $_GET["q"];

$hint = "";

$eventos = $database->getEventosByNombreG($tagBuscada, $tagBuscada2);
echo '	<ul>';
foreach($eventos as $name){

  echo  '<li><a href="evento.php?id='.$name->id.'"</a><strong>'.$name->nombre.'</strong></li>';

}


?>
