<?php

require "../Database.php";
$database = new Database();

$filter = $_GET['filter'] ?? "";

if (empty($filter)) {
    echo "error";
    return;
}

$resultado = $database->searchComentariosByInput($filter);
echo json_encode($resultado);
?>
