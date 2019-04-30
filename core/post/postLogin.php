<?php

require "../Database.php";
$database = new Database();

$emailLogin = $_POST['email'] ?? "";
$passwordLogin = $_POST['password'] ?? "";

if (empty($emailLogin) || empty($passwordLogin)) {
  echo "error (post)";
} else {
  session_start();
  $userBuscado = $database->getUsuarioByEmail($emailLogin);
  if (is_null($userBuscado)) {
    echo "error (null)";
  } else {
    if (password_verify($passwordLogin, $userBuscado->password)) {
      $_SESSION["loggedUserId"] = $userBuscado->id;
      header("Location: /index.php");
    } else {
      echo "error (password)";
    }
   }
}
?>
