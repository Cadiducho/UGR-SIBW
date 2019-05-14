<?php

require "core/Twig.php";
require "core/Database.php";
require "core/Core.php";

$database = new Database();
$core = new Core($twig, $database);

$loggedUser = $database->getUsuarioById($_SESSION["loggedUserId"]);

if ($loggedUser == NULL) {
  header("Location: ../../index.php");
  return;
} else if ($loggedUser->rango < Usuario::MODERADOR) {
  header("Location: ../../index.php");
  return;
}

// Si se está editando etiquetas o galería mostrar otra plantilla
$editEtiquetas = $_GET['editEtiquetas'] ?? "";

if (!empty($editEtiquetas) ||$loggedUser->rango < Usuario::GESTOR) {
    $evento = $database->getEvento($editEtiquetas);
    $tags = $database->getTagsOfEvent($evento->id);
    $evento->etiquetas = $tags;
    if ($evento != null) {
        echo $core->render('admin/editEtiquetas.twig', ["evento" => $evento]);
    } else {
        echo $core->render('eventoNotFound.twig');
    }
    return;
}

$editGaleria = $_GET['editGaleria'] ?? "";

if (!empty($editGaleria) || $loggedUser->rango < Usuario::GESTOR) {
    $evento = $database->getEvento($editGaleria);
    $galeria = $database->getGaleriaEvento($evento->id);
    $evento->galeria = $galeria;
    if ($evento != null) {
        echo $core->render('admin/editGaleria.twig', ["evento" => $evento]);
    } else {
        echo $core->render('eventoNotFound.twig');
    }
    return;
}

// Si no, mostrar el panel normal
$parametros = array();

if ($loggedUser->rango >= Usuario::MODERADOR) {
    $parametros["comentarios"] = $database->getAllComentarios();
}

if ($loggedUser->rango >= Usuario::GESTOR) {
    $parametros["eventos"] = $database->getAllEventos();
}

if ($loggedUser->rango >= Usuario::SUPERUSUARIO) {
    $parametros["usuarios"] = $database->getAllUsuarios();

}
echo $core->render('admin/panel.twig', $parametros);
?>
