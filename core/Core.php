<?php

class Core {

  private $twig;
  private $database;

  function Core($twig, $database) {
      $this->twig = $twig;
      $this->database = $database;

      session_start();
  }

  public function get($key) {
    return $_SESSION[$key] ?? NULL;
  }


  // Funcion para renderizar un template de twig siempre enviando el usuario que esté iniciado sesión, si existe
  function render($template, $parameters = []) {
      $loggedUserId = $this->get("loggedUserId");
      $loggedUser = $this->database->getUsuarioById($loggedUserId);

      $parameters["loggedUser"] = $loggedUser;
      return $this->twig->render($template, $parameters);
  }
}

?>
