<?php
require 'vendor/autoload.php';

$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader);

echo $twig->render(
    'biscuits.twig',
    [
        'title' => 'ISIWEB4SHOP - Biscuits',
        'payer' => 'Voir Panier/Payer',
        'heading' => 'Nos biscuits',
        'itemsDescription'=> ['*desc*','*desc*','*desc*'],
        'listTitle' => 'NOS OFFRES',
        'items' => ['Assortiments', 'Shortbreads', 'Sablés'], // Ajoutez vos offres spécifiques aux biscuits ici
        'account' => 'Votre Compte',
    ]
);
?>
