<?php
session_start();
require 'vendor/autoload.php';
require './models/connect.php';

try {
    $pdo = new PDO('mysql:host='.SERVER.';dbname='.BASE, USER, PASSWD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    throw new Exception('Fail: ' . $e->getMessage());
}

$statement = $pdo->query("SELECT panier.quantity, products.* FROM panier JOIN products ON panier.product_id = products.id");
$cartItems = $statement->fetchAll(PDO::FETCH_ASSOC);

$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader);

echo $twig->render(
    'order.twig', 
    [
        'title' => 'ISIWEB4SHOP - Panier',
        'heading' => 'Votre Panier',
        'cartItems' => $cartItems,
        'account' => 'Votre Compte',
    ]
);
?>