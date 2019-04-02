<?php

$ROOT_PATH = dirname(__DIR__);
require_once $ROOT_PATH . '/vendor/autoload.php';

$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader, [
    'cache' => 'compilation_cache',
    'cache' => false,
]);

?>
