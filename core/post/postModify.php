<?php

require "../Database.php";
$database = new Database();

$emailRegister = $_POST['email'] ?? "";
$nicknameRegister  = $_POST['nickname'] ?? "";
$passwordRegister = $_POST['password'] ?? "";
$passwordConfirm = $_POST['passwordConfirm'] ?? "";



session_start();
$userBuscado = $database->getUsuarioById($_SESSION["loggedUserId"]);

if ($passwordRegister != $passwordConfirm) {
  header("Location: ../../usuario.php?updated=error");
}
else {
  if (empty($passwordRegister))
    $passwordRegister  = $userBuscado->password;
  else
    $passwordRegister = password_hash($passwordRegister, PASSWORD_BCRYPT);

  $database->modificarUsuario($emailRegister, $nicknameRegister, $passwordRegister, $userBuscado->id);
      header("Location: ../../usuario.php?updated=ok");
}

?>
