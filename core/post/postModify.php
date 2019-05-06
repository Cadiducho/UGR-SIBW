<?php

require "../Database.php";
$database = new Database();

$emailRegister = $_POST['email'] ?? "";
$nicknameRegister  = $_POST['nickname'] ?? "";
$passwordRegister = $_POST['password'] ?? "";
$passwordConfirm = $_POST['passwordConfirm'] ?? "";

session_start();
$userBuscado = $database->getUsuarioById($_SESSION["loggedUserId"]);

if (empty($emailRegister))
  $emailRegister = $userBuscado->email;
if (empty($nicknameRegister))
  $nicknameRegister  = $userBuscado->nickname;
if (empty($passwordRegister))
  $passwordRegister  = $userBuscado->password;
if (empty($passwordConfirm))
  $passwordConfirm  = $userBuscado->password;

if ($passwordRegister != $passwordConfirm) {
  header("Location: ../../usuario.php?updated=error");
} else {

  $database->modificarUsuario($emailRegister, $nicknameRegister, password_hash($passwordRegister, PASSWORD_BCRYPT), $userBuscado->id);
      header("Location: ../../usuario.php?updated=ok");
  }
?>
