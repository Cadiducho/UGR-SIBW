<?php
$ROOT_PATH = dirname(__DIR__);
require_once $ROOT_PATH . '/core/modelo/Evento.php';

class Database {

  private $mysqli;

  function Database() {
    $hostname = "localhost";
    $username = "sibw";
    $password = "sibw";
    $databaseName = "sibw";
    $this->mysqli = new mysqli($hostname, $username, $password, $databaseName);

    if (mysqli_connect_errno()) {
        printf("Conexión errónea: %s\n", mysqli_connect_error());
        exit();
    }
  }

  public function getEventosPortada() {
    $queryEventos = "SELECT id, nombre, imagen FROM eventos";
    $resultEventos = $this->mysqli->query($queryEventos);

    $eventos = array();
    while ($row = $resultEventos->fetch_array()) {
        $evento = new Evento($row["id"], $row["nombre"], $row["imagen"]);
        $eventos[$row["id"]] = $evento;
    }

    return $eventos;
  }
}

?>
