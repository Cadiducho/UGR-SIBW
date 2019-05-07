<?php
class Comentario {

    // Id numerico del comentario
    public $id;

    // Autor del comentario
    public $usuario;

    // Fecha en la que se realizó el comentario
    public $fecha;

    // El cuerpo del comentario
    public $mensaje;

    // La referencia al evento donde se comentó
    public $evento;

    function Comentario($id, $usuario, $fecha, $mensaje, $evento = NULL) {
      $this->id = $id;
      $this->usuario = $usuario;
      $this->fecha = $fecha;
      $this->mensaje = $mensaje;
      $this->evento = $evento;
    }

}
?>
