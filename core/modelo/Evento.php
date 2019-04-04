<?php
class Evento {

    public $id;
    public $nombre;
    public $imagen;
    public $organizador;
    public $fecha;
    public $descripcion;
    public $imagen_lateral_1;
    public $imagen_lateral_1_descripcion;
    public $imagen_lateral_2;
    public $imagen_lateral_2_descripcion;
    public $creado_en;
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
