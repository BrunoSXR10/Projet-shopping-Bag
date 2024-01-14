<?php
session_start();
require 'vendor/autoload.php';
require './models/connect.php';

try {
    $pdo = new PDO('mysql:host=' . SERVER . ';dbname=' . BASE, USER, PASSWD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    throw new Exception('Fail: ' . $e->getMessage());
}

$statement = $pdo->query("SELECT panier.quantity, products.* FROM panier JOIN products ON panier.product_id = products.id");
$cartItems = $statement->fetchAll(PDO::FETCH_ASSOC);

$registered = 1;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['finish'])) {
    $customer_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
    $registered = $_POST['name']; // Substitua por seu campo correspondente
    $delivery_add_id = $_POST['address'] ? $_SESSION['address'] : null;
    $payment_type = $_POST['payment_type'];
    $date = date('Y-m-d H:i:s'); // Use a data atual ou como preferir
    $status = 'pending'; // Ou qualquer status inicial desejado
    $session = session_id(); // Obter o ID da sessão atual
    $total = 0; // Inicialize com zero, pois você precisará calcular isso com base nos itens do carrinho

    // Lógica para calcular o total com base nos itens do carrinho
    foreach ($_POST['cart_items'] as $item) {
        $total += $item['quantity'] * $item['price'];
    }

    try {
        // Inserir dados na tabela "order"
        $stmt = $pdo->prepare('INSERT INTO `orders` (customer_id, registered, delivery_add_id, payment_type, date, status, session, total) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
        $stmt->execute([$customer_id, $registered, $delivery_add_id, $payment_type, $date, $status, $session, $total]);
        
        // Obter o ID da ordem recém-inserida
        $order_id = $pdo->lastInsertId();

        // Inserir itens do carrinho na tabela de itens do pedido
        $stmt = $pdo->prepare('INSERT INTO orderitems (order_id, product_id, quantity) VALUES (?, ?, ?)');
        foreach ($_POST['cart_items'] as $item) {
            $stmt->execute([$order_id, $item['id'], $item['quantity']]);
        }

        // Redirecionar para a página de confirmação ou qualquer outra ação necessária
        header('Location: confirmation.php');
        exit();
    } catch (PDOException $e) {
        die('Error: ' . $e->getMessage());
    }
}

$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader);

echo $twig->render(
    'order.twig',
    [
        'title' => 'ISIWEB4SHOP - Panier',
        'heading' => 'Payment',
        'cartItems' => $cartItems,
        'account' => 'Votre Compte',
    ]
);
?>