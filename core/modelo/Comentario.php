<?php
class Comentario {

    // Id numerico del comentario
    public $id;

    // Nombre del autor
    public $autor;

    // Email del autor
    public $email;

    // Fecha en la que se realizó el comentario
    public $fecha;

    // El cuerpo del comentario
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
