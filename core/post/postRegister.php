<?php

require "../Database.php";
$database = new Database();

$emailRegister = $_POST['email'] ?? "";
$nicknameRegister  = $_POST['nickname'] ?? "";
$passwordRegister = $_POST['password'] ?? "";

if (empty($emailRegister) || empty($nicknameRegister) || empty($passwordRegister)) {
  echo "error";
} else {
  $userBuscado = $database->getUsuarioByEmail($emailRegister);
  if (!is_null($userBuscado)) {
    echo "email"; //ya existe un usuario con ese email
  } else {
      $database->registrarUsuario($emailRegister, $nicknameRegister, password_hash($passwordRegister, PASSWORD_BCRYPT));
      echo "ok";
  }
}
?>
