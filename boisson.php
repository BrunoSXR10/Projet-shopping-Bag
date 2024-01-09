<?php
require 'vendor/autoload.php';

$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader);

echo $twig->render(
    'boisson.twig',
    [
        'title' => 'ISIWEB4SHOP - Boissons',
        'heading' => 'Nos Boissons',
        'subtitle' => 'Votre description de la section boissons ici.',
        'items' => ['Sachets de thé', 'Café','Jus exotique'], // Ajoutez vos offres spécifiques aux boissons ici
        'itemsDescription' => [
            '*desc*',
            '*desc*',
            '*desc*'
        ],
    ]
);
?>
