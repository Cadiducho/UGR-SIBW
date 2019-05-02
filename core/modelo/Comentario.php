<?php
class Comentario {

    // Id numerico del comentario
    public $id;

    // Autor deol comentario
    public $usuario;

    // Fecha en la que se realizó el comentario
    public $fecha;

    // El cuerpo del comentario
    public $mensaje;

    function Comentario($id, $usuario, $fecha, $mensaje) {
      $this->id = $id;
      $this->usuario = $usuario;
      $this->fecha = $fecha;
      $this->mensaje = $mensaje;
    }

}
?>
