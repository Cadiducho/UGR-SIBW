<?php
class Comentario {

    public $id;
    public $autor;
    public $email;
    public $fecha;
    public $mensaje;

    function Comentario($id, $autor, $email, $fecha, $mensaje) {
      $this->id = $id;
      $this->autor = $autor;
      $this->email = $email;
      $this->fecha = $fecha;
      $this->mensaje = $mensaje;
    }

}
?>
