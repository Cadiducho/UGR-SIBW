<?php
$ROOT_PATH = dirname(__DIR__);
require_once $ROOT_PATH . '/core/modelo/Evento.php';
require_once $ROOT_PATH . '/core/modelo/Comentario.php';
require_once $ROOT_PATH . '/core/modelo/Tag.php';
require_once $ROOT_PATH . '/core/modelo/Contacto.php';
require_once $ROOT_PATH . '/core/modelo/Usuario.php';
require_once $ROOT_PATH . '/core/modelo/FotoGaleria.php';

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
    $queryEventos = "SELECT * FROM eventos";
    $stmt = $this->mysqli->prepare($queryEventos);
    $stmt->execute();
    $resultEventos = $stmt->get_result();

    $eventos = array();
    while ($row = $resultEventos->fetch_array()) {
      $evento = new Evento(
          $row["id"], $row["nombre"], $row["imagen"],
          $row["organizador"], $row["fecha"], $row["descripcion"],
          $row["imagen_lateral_1"], $row["imagen_lateral_1_descripcion"],
          $row["imagen_lateral_2"], $row["imagen_lateral_2_descripcion"],
          $row["video_id"], $row["creado_en"], $row["actualizado_en"], $row["publicado"]);
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
    $queryComentarios = "SELECT c.id, (u.id) as userid, u.email, u.nickname, c.fecha, c.mensaje, (SELECT a.nickname FROM usuarios a WHERE a.id = editadoPor) as editadoPor, c.fechaEdit FROM comentarios c JOIN usuarios u ON (c.usuario = u.id) WHERE evento=?";
    $stmt = $this->mysqli->prepare($queryComentarios);
    $stmt->bind_param("i", $idEvento);
    $stmt->execute();
    $resultComentarios = $stmt->get_result();

    $comentarios = array();
    while ($row = $resultComentarios->fetch_array()) {
        $usuarioAutor = new Usuario($row["userid"], $row["nickname"], $row["email"]);
        $comentario = new Comentario($row["id"], $usuarioAutor, $row["fecha"], $row["mensaje"], $idEvento, $row["fechaEdit"], $row["editadoPor"]);
        $comentarios[$row["id"]] = $comentario;
    }
    $stmt->close();
    return $comentarios;
  }

  public function getAllComentarios() {
    $queryComentarios = "SELECT c.id, (u.id) as userid, (e.id) as eventid, (e.nombre) as eventnombre, u.email, u.nickname, c.fecha, c.mensaje, (SELECT a.nickname FROM usuarios a WHERE a.id = editadoPor) as editadoPor, c.fechaEdit FROM comentarios c JOIN usuarios u ON (c.usuario = u.id) JOIN eventos e ON (c.evento = e.id)";
    $stmt = $this->mysqli->prepare($queryComentarios);
    $stmt->execute();
    $resultComentarios = $stmt->get_result();

    $comentarios = array();
    while ($row = $resultComentarios->fetch_array()) {
        $usuarioAutor = new Usuario($row["userid"], $row["nickname"], $row["email"]);
        $evento = new Evento($row["eventid"], $row["eventnombre"], "");
        $comentario = new Comentario($row["id"], $usuarioAutor, $row["fecha"], $row["mensaje"], $evento, $row["fechaEdit"], $row["editadoPor"]);
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
    $queryGaleria = "SELECT id, foto, descripcion FROM fotos_galeria WHERE evento=?";
    $stmt = $this->mysqli->prepare($queryGaleria);
    $stmt->bind_param("i", $idEvento);
    $stmt->execute();
    $resultGaleria = $stmt->get_result();

    $galeria = array();
    while ($row = $resultGaleria->fetch_array()) {
        $foto = new FotoGaleria($row["id"], $row["foto"], $row["descripcion"]);
        $galeria[] = $foto;
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

  public function getEventosByNombre($nombre, $descripcion) {
    $queryEventos = "SELECT * FROM eventos e WHERE (nombre
                      LIKE CONCAT('%',?,'%')
                      OR descripcion LIKE CONCAT('%',?,'%'))
                      AND publicado = 'S'";
    $stmt = $this->mysqli->prepare($queryEventos);
    $stmt->bind_param("ss", $nombre, $descripcion);
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

  public function getEventosByNombreG($nombre, $descripcion) {
    $queryEventos = "SELECT * FROM eventos e WHERE nombre
                      LIKE CONCAT('%',?,'%')
                      OR descripcion LIKE CONCAT('%',?,'%')";
    $stmt = $this->mysqli->prepare($queryEventos);
    $stmt->bind_param("ss", $nombre, $descripcion);
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

  public function searchComentariosByInput($filter) {
    $queryComentarios = "SELECT c.id, u.nickname AS nickname, u.id as userid, u.email as email, e.id AS eventid, e.nombre AS eventname, c.mensaje, c.fecha
            FROM comentarios c
            JOIN usuarios u ON (c.usuario = u.id)
            JOIN eventos e ON (c.evento = e.id)
            WHERE c.mensaje LIKE CONCAT('%',?,'%') OR u.nickname LIKE CONCAT('%',?,'%')";
    $stmt = $this->mysqli->prepare($queryComentarios);
    $stmt->bind_param("ss", $filter, $filter);
    $stmt->execute();
    $resultComentarios = $stmt->get_result();

    $comentarios = array();
    while ($row = $resultComentarios->fetch_array()) {
        $usuarioAutor = new Usuario($row["userid"], $row["nickname"], $row["email"]);
        $evento = new Evento($row["eventid"], $row["eventname"], "");
        $comentario = new Comentario($row["id"], $usuarioAutor, $row["fecha"], $row["mensaje"], $evento, "", "");
        $comentarios[] = $comentario;
    }
    $stmt->close();
    return $comentarios;
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

  public function insertarComentario($evento, $userid, $texto, $fecha, $ip) {
    $queryTags = "INSERT INTO comentarios (evento, usuario, fecha, mensaje, ip) VALUES (?, ?, ?, ?, ?)";
    $stmt = $this->mysqli->prepare($queryTags);
    $stmt->bind_param("issss", $evento, $userid, $fecha, $texto, $ip);
    $stmt->execute();

    $stmt->close();
  }

  public function editComentario($comentario, $mensaje, $adminid) {
      $updateComentario = "UPDATE comentarios SET mensaje=?, editadoPor=? WHERE id=?;";
      $stmt = $this->mysqli->prepare($updateComentario);
      $stmt->bind_param("ssi", $mensaje, $adminid, $comentario);
      $stmt->execute();
      $stmt->close();
  }

  public function deleteComentario($comentario) {
      $updateComentario = "DELETE FROM comentarios WHERE id=?;";
      $stmt = $this->mysqli->prepare($updateComentario);
      $stmt->bind_param("i", $comentario);
      $stmt->execute();
      $stmt->close();
  }

  public function getUsuarioById($id) {
    $queryUsuarios = "SELECT * FROM usuarios WHERE id=?";
    $stmt = $this->mysqli->prepare($queryUsuarios);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $resultUsuario = $stmt->get_result();

    $usuario = NULL;
    if ($row = $resultUsuario->fetch_assoc()) {
        $usuario = new Usuario($row["id"], $row["nickname"], $row["email"], $row["password"], $row["rango"]);
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
        $usuario = new Usuario($row["id"], $row["nickname"], $row["email"], $row["password"], $row["rango"]);
    }
    $stmt->close();
    return $usuario;
  }

  public function registrarUsuario($email, $nickname, $password) {
    $queryRegistro = "INSERT INTO usuarios (email, nickname, password) VALUES (?, ?, ?)";
    $stmt = $this->mysqli->prepare($queryRegistro);
    $stmt->bind_param("sss", $email, $nickname, $password);
    $stmt->execute();

    $stmt->close();
  }

  public function modificarUsuario($email, $nickname, $password, $idBuscada) {
    $queryModifica = "UPDATE usuarios SET email=?, nickname=?, password=?
                      WHERE id=?";
    $stmt = $this->mysqli->prepare($queryModifica);
    $stmt->bind_param("sssi", $email, $nickname, $password, $idBuscada);
    $stmt->execute();

    $stmt->close();
  }

  public function getAllUsuarios() {
    $queryUsuarios = "SELECT id as userid, email, nickname, password, rango  FROM usuarios";
    $stmt = $this->mysqli->prepare($queryUsuarios);
    $stmt->execute();
    $resultUsuarios= $stmt->get_result();

    $usuarios = array();
    while ($row = $resultUsuarios->fetch_array()) {
        $usuario = new Usuario($row["userid"], $row["nickname"], $row["email"], $row["password"], $row["rango"]);
        $usuarios[$row["userid"]] = $usuario;
    }
    $stmt->close();

    return $usuarios;

  }

  public function editUsuario($usuario, $rango) {
      $updateUsuario = "UPDATE usuarios SET rango=? WHERE id=?;";
      $stmt = $this->mysqli->prepare($updateUsuario);
      $stmt->bind_param("is", $rango, $usuario);
      $stmt->execute();
      $stmt->close();
  }

  public function countUsuario($rango) {
      $countNumUsuario = "SELECT count(*) as cantidadUser from usuarios where rango=?;";
      $stmt = $this->mysqli->prepare($countNumUsuario);
      $stmt->bind_param("i", $rango);
      $stmt->execute();
      $resultCountUsuarios= $stmt->get_result();

      $countUser = 0;
      if ($row = $resultCountUsuarios->fetch_array()) {
          $countUser = $row["cantidadUser"];
      }

      $stmt->close();

      return $countUser;
  }

  public function rangoUsuario($usuario) {
      $rangoUsuario = "SELECT rango from usuarios where id=?;";
      $stmt = $this->mysqli->prepare($rangoUsuario);
      $stmt->bind_param("i", $usuario);
      $stmt->execute();
      $resultRangoUsuario= $stmt->get_result();

      $rangosUser = 0;
      if ($row = $resultRangoUsuario->fetch_array()) {
          $rangosUser = $row["rango"];
      }

      $stmt->close();

      return $rangosUser;
  }

  public function getAllEventos() {
    $queryEventos = "SELECT id as eventoid, nombre, imagen, organizador, fecha, descripcion, imagen_lateral_1,
                      imagen_lateral_1_descripcion, imagen_lateral_2, imagen_lateral_2_descripcion,
                      video_id, creado_en, actualizado_en FROM eventos";
    $stmt = $this->mysqli->prepare($queryEventos);
    $stmt->execute();
    $resultEventos= $stmt->get_result();

    $eventos = array();
    while ($row = $resultEventos->fetch_array()) {
        $evento = new Evento($row["eventoid"], $row["nombre"], $row["imagen"], $row["organizador"], $row["fecha"],
                      $row["descripcion"], $row["imagen_lateral_1"], $row["imagen_lateral_1_descripcion"],
                      $row["imagen_lateral_2"], $row["imagen_lateral_2_descripcion"],
                      $row["video_id"], $row["creado_en"], $row["actualizado_en"]);
        $evento->etiquetas = $this->getTagsOfEvent($row["eventoid"]);
        $evento->galeria = $this->getGaleriaEvento($row["eventoid"]);
        $eventos[$row["eventoid"]] = $evento;
    }
    $stmt->close();

    return $eventos;
  }

  public function registrarEvento($nombreRegister, $imagenRegister, $organizadorRegister, $fechaRegister, $descripcionRegister, $img1Register, $img1descRegister, $img2Register, $img2descRegister) {
    $queryRegistroEvento = "INSERT INTO eventos (nombre, imagen, organizador, fecha, descripcion, imagen_lateral_1, imagen_lateral_1_descripcion,
                        imagen_lateral_2, imagen_lateral_2_descripcion) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $this->mysqli->prepare($queryRegistroEvento);
    $stmt->bind_param("sssssssss", $nombreRegister, $imagenRegister, $organizadorRegister, $fechaRegister, $descripcionRegister, $img1Register, $img1descRegister, $img2Register, $img2descRegister);
    $stmt->execute();

    $stmt->close();
  }


  public function editarEvento($evento, $nombre, $imagen, $organizador, $fecha, $descripcion, $img1, $img1desc, $img2, $img2desc) {
    $queryUpdateEvento = "UPDATE eventos SET nombre=?, imagen=?, organizador=?, fecha=?, descripcion=?,
                            imagen_lateral_1=?, imagen_lateral_1_descripcion=?, imagen_lateral_2=?, imagen_lateral_2_descripcion=?
                            WHERE id=?;";

    $stmt = $this->mysqli->prepare($queryUpdateEvento);
    $stmt->bind_param("sssssssssi", $nombre, $imagen, $organizador, $fecha, $descripcion, $img1, $img1desc, $img2, $img2desc, $evento);
    $stmt->execute();

    $stmt->close();
  }

  public function deleteEvento($evento) {
      $deleteEvento = "DELETE FROM eventos WHERE id=?;";
      $stmt = $this->mysqli->prepare($deleteEvento);
      $stmt->bind_param("i", $evento);
      $stmt->execute();
      $stmt->close();
  }

  public function deleteEtiquetaFromEvento($evento, $etiqueta) {
      $deleteTag = "DELETE FROM eventos_tags WHERE evento=? AND tag=?;";
      $stmt = $this->mysqli->prepare($deleteTag);
      $stmt->bind_param("is", $evento, $etiqueta);
      $stmt->execute();
      $stmt->close();
  }

  public function addTagToEvent($evento, $etiqueta) {
      $addTag = "INSERT INTO eventos_tags (`evento`, `tag`) VALUES (?, ?);";
      $stmt = $this->mysqli->prepare($addTag);
      $stmt->bind_param("is", $evento, $etiqueta);
      $stmt->execute();
      $stmt->close();
  }

  public function deleteGaleriaFromEvento($evento, $galeria) {
      $deleteImage = "DELETE FROM fotos_galeria WHERE evento=? AND id=?;";
      $stmt = $this->mysqli->prepare($deleteImage);
      $stmt->bind_param("ii", $evento, $galeria);
      $stmt->execute();
      $stmt->close();
  }

  public function addImageToEvent($evento, $imagen, $descripcion) {
      $addTag = "INSERT INTO fotos_galeria (`evento`, `foto`, `descripcion`) VALUES (?, ?, ?);";
      $stmt = $this->mysqli->prepare($addTag);
      $stmt->bind_param("iss", $evento, $imagen, $descripcion);
      $stmt->execute();
      $stmt->close();
  }

}

?>
