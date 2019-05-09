<?php

require "../../Database.php";
$database = new Database();
$contadorUsuarios = 0;
$usuario = $_POST['usuario'] ?? "";
$rango = $_POST['rango'] ?? "";

if (empty($usuario) || empty($rango)) {
    echo "error";
    return;
}

$rangoUsuario = $database->rangoUsuario($usuario);

if($rangoUsuario == 40){
      $contadorUsuarios = $database->countUsuario($rangoUsuario);

      if($contadorUsuarios<=1){
        echo "error";
        return;
      }
}

$database->editUsuario($usuario, $rango);

echo "ok";




?>
