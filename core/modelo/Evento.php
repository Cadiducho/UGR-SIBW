<?php
class Evento {

    // Id numerica del evento
    public $id;

    // Nombre del evento
    public $nombre;

    // Url a la imagen de portada del evento
    public $imagen;

    // Nombre del o los organizadores
    public $organizador;

    // Fechas en las que el evento tiene lugar
    public $fecha;

    // Texto descriptivo a mostrar en su pagina detallada
    public $descripcion;

    public $imagen_lateral_1;
    public $imagen_lateral_1_descripcion;
    public $imagen_lateral_2;
    public $imagen_lateral_2_descripcion;

    // Timestamp en el que la pagina del evento fue creado
    public $creado_en;

    // Timestamp en el que la pagina del evento fue actualizado
    public $actualizado_en;

    function Evento($id, $nombre, $imagen, $organizador = "", $fecha = "", $descripcion="", $imagen_lateral_1 = "", $imagen_lateral_1_descripcion = "", $imagen_lateral_2 = "", $imagen_lateral_2_descripcion = "", $creado_en = "", $actualizado_en = "") {
      $this->id = $id;
      $this->nombre = $nombre;
      $this->imagen = $imagen;
      $this->organizador = $organizador;
      $this->fecha = $fecha;
      $this->descripcion = $descripcion;
      $this->imagen_lateral_1 = $imagen_lateral_1;
      $this->imagen_lateral_1_descripcion = $imagen_lateral_1_descripcion;
      $this->imagen_lateral_2 = $imagen_lateral_2;
      $this->imagen_lateral_2_descripcion = $imagen_lateral_2_descripcion;
      $this->creado_en = $creado_en;
      $this->actualizado_en = $actualizado_en;
    }

}
?>
