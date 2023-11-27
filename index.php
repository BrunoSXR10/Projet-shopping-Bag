<?php
require 'vendor/autoload.php';


$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader);


echo $twig->render(
    'index.twig',
    [
        'title' => 'ISIWEB4SHOP',
        'link' => 'Voir Panier/Payer',
        'heading' => 'BIENVENUE!!',
        'subtitle' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
        'listTitle' => 'NOTRE OFFER',
        'items' => ['Boisson', 'Biscuits', 'Fruits sec'],
    ],
);
?>