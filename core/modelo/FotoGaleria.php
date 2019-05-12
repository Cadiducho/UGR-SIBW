<?php
class FotoGaleria {

  public $id;
  public $link;
  public $descripcion;

  function FotoGaleria($id, $link, $descripcion) {
    $this->id = $id;
    $this->link = $link;
    $this->descripcion = $descripcion;
  }

}

?>
