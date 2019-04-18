<?php
class Contacto {

    // Titulo del contacto
    public $titulo;

    // Subtitulo del contacto
    public $subtitulo;

    // Información general del contacto
    public $informacion_general;

    // Imagen izquierda del comentario
    public $imagen_izquierda;

    // Imagen derecha del comentario
    public $imagen_derecha;

    // Descripcion izquierda del comentario
    public $descripcion_izquierda;

    // Descripcion derecha del comentario
    public $descripcion_derecha;

    function Contacto($titulo, $subtitulo, $informacion_general, $imagen_izquierda, $imagen_derecha, $descripcion_izquierda, $descripcion_derecha) {
      $this->titulo = $titulo;
      $this->subtitulo = $subtitulo;
      $this->informacion_general = $informacion_general;
      $this->imagen_izquierda = $imagen_izquierda;
      $this->imagen_derecha = $imagen_derecha;
      $this->descripcion_izquierda = $descripcion_izquierda;
      $this->descripcion_derecha = $descripcion_derecha;
    }

}
?>
