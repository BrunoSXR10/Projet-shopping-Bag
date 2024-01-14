<?php
require 'vendor/autoload.php';
require './models/connect.php';

try {
    $pdo = new PDO('mysql:host='.SERVER.';dbname='.BASE, USER, PASSWD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}  catch (PDOException $e) {
    throw new Exception('Fail: ' . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $surname = $_POST['surname'];
    $forname = $_POST['forname'];
    $city =  $_POST['city'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];

    try {
        $stmt = $pdo->prepare('INSERT INTO customers (surname, forname, city, address, email, phone, password) VALUES (?, ?, ?, ?, ?, ?, ?)');
        $stmt->execute([$surname, $forname, $city, $address, $email, $phone, $password]);
    } catch (PDOException $e) {
        die('Error to insert: ' . $e->getMessage());
    }

    header('Location: success.php');
    exit;
}

require_once 'vendor/autoload.php';

$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader);

echo $twig->render(
    'register.twig', [
        'title' => 'ISIWEB4SHOP',
        'payer' => 'Voir Panier/Payer',
        'listTitle' => 'NOTRE OFFER',
        'items' => ['Boisson', 'Biscuits', 'Fruits sec'],
        'Surname'=> 'Surname',
        'Forname'=> 'Forname',
        'City' => 'City',
        'Address' => 'Address',
        'Email'=> 'Email',
        'Phone'=> 'Phone',
        'Password' => 'Password'
    ],
);

