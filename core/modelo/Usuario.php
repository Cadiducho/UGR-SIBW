<?php

class Usuario {

  public $id;

  public $nickname;

  public $email;

  public $password;

  public $rango;

  function Usuario($id, $nickname, $email, $password, $rango = ANONIMO) {
    $this->id = $id;
    $this->nickname = $nickname;
    $this->email = $email;
    $this->password = $password;
    $this->rango = $rango;
  }

  const ANONIMO = 0;
  const REGISTRADO = 10;
  const MODERADOR = 20;
  const GESTOR = 30;
  const SUPERUSUARIO = 40;

}
?>
