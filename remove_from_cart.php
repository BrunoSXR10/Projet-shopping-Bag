<?php
session_start();
require 'vendor/autoload.php';
require './models/connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove'])) {
    $itemToRemove = $_POST['remove'];

    try {
        $pdo = new PDO('mysql:host='.SERVER.';dbname='.BASE, USER, PASSWD);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare('DELETE FROM panier WHERE product_id = ?');
        $stmt->execute([$itemToRemove]);
    } catch (PDOException $e) {
        die('Error to remove: ' . $e->getMessage());
    }

    // Redirecione de volta para a página do carrinho após a remoção
    header('Location: panier.php');
    exit;
}
?>
