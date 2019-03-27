<?php
require_once 'vendor/autoload.php';

$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader, [
    'cache' => 'compilation_cache',
]);

echo $twig->render('portada.twig', ['web_title' => 'Mario Tennis Club']);

?>
