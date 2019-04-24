<?php
$ROOT_PATH = dirname(__DIR__);
require_once $ROOT_PATH . '/core/modelo/Evento.php';
require_once $ROOT_PATH . '/core/modelo/Comentario.php';
require_once $ROOT_PATH . '/core/modelo/Tag.php';
require_once $ROOT_PATH . '/core/modelo/Contacto.php';
require_once $ROOT_PATH . '/core/modelo/Usuario.php';

class Database {

  private $mysqli;

  function Database() {
    $hostname = "dandelion.cadiducho.com";
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
    $stmt = $this->mysqli->prepare($queryEventos);
    $stmt->execute();
    $resultEventos = $stmt->get_result();

    $eventos = array();
    while ($row = $resultEventos->fetch_array()) {
        $evento = new Evento($row["id"], $row["nombre"], $row["imagen"]);
        $eventos[$row["id"]] = $evento;
    }
    $stmt->close();

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
            $row["imagen_lateral_2"], $row["imagen_lateral_2_descripcion"],
            $row["video_id"], $row["creado_en"], $row["actualizado_en"]
        );
    }
    $stmt->close();
    return $evento;
  }

  public function getComentariosEvento($idEvento) {
    $queryComentarios = "SELECT id, autor, email, fecha, mensaje FROM comentarios WHERE evento=?";
    $stmt = $this->mysqli->prepare($queryComentarios);
    $stmt->bind_param("i", $idEvento);
    $stmt->execute();
    $resultComentarios = $stmt->get_result();

    $comentarios = array();
    while ($row = $resultComentarios->fetch_array()) {
        $comentario = new Comentario(
          $row["id"], $row["autor"], $row["email"],
          $row["fecha"], $row["mensaje"]
        );
        $comentarios[$row["id"]] = $comentario;
    }
    $stmt->close();
    return $comentarios;
  }

  public function getPalabrasProhibidas() {
    $queryProhibidas = "SELECT palabra_prohibida FROM palabras_prohibidas";
    $stmt = $this->mysqli->prepare($queryProhibidas);
    $stmt->execute();
    $resultProhibidas = $stmt->get_result();

    $prohibidas = array();

    while ($row = $resultProhibidas->fetch_array()) {
        $prohibidas[] = $row["palabra_prohibida"];
    }
    $stmt->close();

    return $prohibidas;
  }

  public function getGaleriaEvento($idEvento) {
    $queryGaleria = "SELECT foto, descripcion FROM fotos_galeria WHERE evento=?";
    $stmt = $this->mysqli->prepare($queryGaleria);
    $stmt->bind_param("i", $idEvento);
    $stmt->execute();
    $resultGaleria = $stmt->get_result();

    $galeria = array();
    while ($row = $resultGaleria->fetch_array()) {
        $galeria[$row["foto"]] = $row["descripcion"];
    }
    $stmt->close();

    return $galeria;
  }

  public function getEventosByTag($tag) {
    $queryEventos = "SELECT e.* FROM eventos e JOIN eventos_tags t
                      ON (e.id = t.evento) WHERE t.tag
                      LIKE CONCAT('%',?,'%')";
    $stmt = $this->mysqli->prepare($queryEventos);
    $stmt->bind_param("s", $tag);
    $stmt->execute();
    $resultEventos = $stmt->get_result();

    $eventos = array();
    while ($row = $resultEventos->fetch_array()) {
        $evento = new Evento($row["id"], $row["nombre"], $row["imagen"]);
        $eventos[$row["id"]] = $evento;
    }
    $stmt->close();

    return $eventos;
  }

  public function getTags() {
    $queryTags = "SELECT t.tag as nombre, count(*) as cantidad FROM eventos_tags t GROUP BY t.tag;";
    $stmt = $this->mysqli->prepare($queryTags);
    $stmt->execute();
    $resultTags = $stmt->get_result();

    $tags = array();
    while ($row = $resultTags->fetch_array()) {
        $tag = new Tag($row["nombre"], $row["cantidad"]);
        $tags[$row["nombre"]] = $tag;
    }
    $stmt->close();

    return $tags;
  }

  public function getTagsOfEvent($eventId) {
    $queryTags = "SELECT tag FROM eventos_tags WHERE evento=?";
    $stmt = $this->mysqli->prepare($queryTags);
    $stmt->bind_param("i", $eventId);
    $stmt->execute();
    $resultTags = $stmt->get_result();

    $tags = array();
    while ($row = $resultTags->fetch_array()) {
        $tag = new Tag($row["tag"]);
        $tags[] = $tag;
    }
    $stmt->close();

    return $tags;
  }

  public function getContacto() {
    $queryContacto = "SELECT * FROM conocenos";
    $stmt = $this->mysqli->prepare($queryContacto);
    $stmt->execute();
    $resultContacto = $stmt->get_result();

    $contacto = null;
    if ($row = $resultContacto->fetch_assoc()) {
        $contacto = new Contacto(
            $row["titulo"], $row["subtitulo"], $row["informacion_general"],
            $row["imagen_izquierda"], $row["imagen_derecha"], $row["descripcion_izquierda"],
            $row["descripcion_derecha"]
        );
    }
    $stmt->close();

    return $contacto;
  }

  public function insertarComentario($evento, $nombre, $email, $texto, $fecha, $ip) {
    $queryTags = "INSERT INTO comentarios (evento, autor, email, fecha, mensaje, ip) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $this->mysqli->prepare($queryTags);
    $stmt->bind_param("isssss", $evento, $nombre, $email, $fecha, $texto, $ip);
    $stmt->execute();

    $stmt->close();
  }

  public function getUsuarioById($id) {
    $queryUsuarios = "SELECT * FROM usuarios WHERE id=?";
    $stmt = $this->mysqli->prepare($queryUsuarios);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $resultUsuario = $stmt->get_result();

    $usuario = null;
    if ($row = $resultUsuario->fetch_assoc()) {
        $usuario = new Usuario($row["id"], $row["email"], $row["nickname"], $row["password"], $row["rango"]);
    }
    $stmt->close();
    return $usuario;
  }

  public function getUsuarioByEmail($email) {
    $queryUsuarios = "SELECT * FROM usuarios WHERE email=?";
    $stmt = $this->mysqli->prepare($queryUsuarios);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultUsuario = $stmt->get_result();

    $usuario = null;
    if ($row = $resultUsuario->fetch_assoc()) {
        $usuario = new Usuario($row["id"], $row["email"], $row["nickname"], $row["password"], $row["rango"]);
    }
    $stmt->close();
    return $usuario;
  }
}

?>
