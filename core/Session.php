<?php

class Session {

  private $twig;
  private $database;

  function Session($twig, $database) {
      $this->twig = $twig;
      $this->database = $database;

      session_start();
  }

  function get($key) {
    $_SESSION[$key] ?? null;
  }


  // Funcion para renderizar un template de twig siempre enviando el usuario que esté iniciado sesión, si existe
  function render($template, $parameters) {

      $loggedUserId = $this->get("loggedUserId");
      $loggedUser = $this->database->getUsuarioById($loggedUserId);

      $parameters["loggedUser"] = $loggedUser;
      return $this->twig->render($template, $parameters);
  }
}

?>
