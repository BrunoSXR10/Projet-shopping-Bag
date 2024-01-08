<?php
require 'vendor/autoload.php';
require './models/connect.php';

try {
    $pdo = new PDO('mysql:host='.SERVER.';dbname='.BASE, USER, PASSWD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    throw new Exception('Fail: ' . $e->getMessage());
}

$statement = $pdo->query("SELECT * FROM products WHERE cat_id = 1");
$products = $statement->fetchAll(PDO::FETCH_ASSOC);

foreach ($products as &$item) {
    $item['image'] = 'img/' . $item['image'];
}

$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader);

echo $twig->render(
    'biscuits.twig', 
    [
        'title' => 'ISIWEB4SHOP - Boisson',
        'payer' => 'Voir Panier/Payer',
        'heading' => 'Nos Boissons',
        'itens' => $products,  // <-- Corrigindo para $products
        'listTitle' => 'NOS OFFRES',
        'account' => 'Votre Compte',
    ]
);