<?php
require_once 'vendor/autoload.php';

$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader, [
    'cache' => 'compilation_cache',
    'cache' => false,
]);

echo $twig->render('portada.twig', []);

?>
