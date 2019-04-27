<?php

require "core/Twig.php";
require "core/Database.php";
require "core/Session.php";

session_start();

$database = new Database();
$session = new Session($twig, $database);

$mensaje = "";

$_SESSION["nombre"] = $_POST["loginName"];
$mensaje = "iniciado sesión correctamente";

$nombre = $_SESSION["nombre"] ?? null;
echo $session->render("session_login.twig", ["nombreSesion" => $nombre, "mensaje" => $mensaje]);
?>
