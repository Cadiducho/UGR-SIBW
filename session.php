<?php

require "core/Twig.php";

session_start();

$accion = $_GET['a'] ?? "";
$mensaje = "";

switch ($accion) {
  case "exit":
      $mensaje = "Has cerrado sesión";
      session_unset();
      session_destroy();
    break;
  case "login":
    $_SESSION["nombre"] = $_POST["loginName"];
    $mensaje = "iniciado sesión correctamente";
    break;
}

$nombre = $_SESSION["nombre"] ?? null;
echo $twig->render("session_login.twig", ["nombreSesion" => $nombre, "mensaje" => $mensaje]);
?>
