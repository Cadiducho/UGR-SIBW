<?php
class Tag {

  // Nombre de la tag
  public $nombre;

  // Cantidad de veces que esta tag es utilizada
  public $cantidad;

  function Tag($nombre, $cantidad = 0) {
    $this->nombre = $nombre;
    $this->cantidad = $cantidad;
  }

}

?>
