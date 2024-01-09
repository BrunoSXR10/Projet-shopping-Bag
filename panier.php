<?php
// Autres traitements PHP si nécessaire

require_once 'vendor/autoload.php'; // Chargez l'autoloader de Composer

$loader = new \Twig\Loader\FilesystemLoader(__DIR__.'/templates'); // Spécifiez le répertoire de vos templates
$twig = new \Twig\Environment($loader);

// Récupération des produits depuis votre base de données (ajustez selon votre logique)
$items = [
    ['items' => 'Assortiments'],
    ['items' => 'Sablés'],
    ['items' => 'Shortbreads'],
    ['items' => 'Assortiments'],
    ['items' => 'Sachets de thé'],
    ['items' => 'Cafés'],
    ['items' => 'Jus']
];

echo $twig->render('panier.twig', ['items' => $items]);
