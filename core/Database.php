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
    $this->mysqli->set_charset("utf8");

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

  public function getEvento($id) {
    $queryEventos = "SELECT * FROM eventos WHERE id=?";
    $stmt = $this->mysqli->prepare($queryEventos);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $resultEvento = $stmt->get_result();

    $evento = null;
    if ($row = $resultEvento->fetch_assoc()) {
        $evento = new Evento(
            $row["id"], $row["nombre"], $row["imagen"],
            $row["organizador"], $row["fecha"], $row["descripcion"],
            $row["imagen_lateral_1"], $row["imagen_lateral_1_descripcion"],
            $row["imagen_lateral_2"], $row["imagen_lateral_2_descripcion"]
        );
    }
    return $evento;
  }
}

?>
