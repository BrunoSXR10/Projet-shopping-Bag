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

$statement = $pdo->query("SELECT * FROM products WHERE cat_id = 2");
$product = $statement->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add'])) {
    $item_id = $_POST['item_id'];
    $quantity = $_POST['quantity'];

    try {
        // Consultar o banco de dados para obter informações do item com base no ID
        $stmt = $pdo->prepare('SELECT * FROM products WHERE id = ?');
        $stmt->execute([$item_id]);
        $item = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($item) {
            // Inserir o item no carrinho (tabela "panier")
            $stmt = $pdo->prepare('INSERT INTO panier (product_id, quantity) VALUES (?, ?)');
            $stmt->execute([$item_id, $quantity]);
        }
    } catch (PDOException $e) {
        die('Error to insert: ' . $e->getMessage());
    }

    header('Location: panier.php');
    exit;
}

$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader);

echo $twig->render(
    'product.twig', 
    [
        'title' => 'ISIWEB4SHOP - Biscuits',
        'payer' => 'Voir Panier/Payer',
        'heading' => 'Nos biscuits',
        'itens' => $product,
        'listTitle' => 'NOS OFFRES',
        'account' => 'Votre Compte',
    ]
);

?>
