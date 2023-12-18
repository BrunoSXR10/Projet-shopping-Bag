<?php
require 'vendor/autoload.php';
require './models/connect.php';

// Conexão com o banco de dados usando PDO
try {
    $pdo = new PDO('mysql:host='.SERVER.';dbname='.BASE, USER, PASSWD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Erro na conexão com o banco de dados: ' . $e->getMessage());
}

// Se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtenha os dados do formulário
    $surname = $_POST['surname'];
    $forname = $_POST['forname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    // Faça o que for necessário com esses dados, por exemplo, salvar em um banco de dados
    try {
        $stmt = $pdo->prepare('INSERT INTO customers (surname, forname, email, phone) VALUES (?, ?, ?, ?)');
        $stmt->execute([$surname, $forname, $email, $phone]);
    } catch (PDOException $e) {
        die('Erro ao inserir dados no banco de dados: ' . $e->getMessage());
    }

    // Redirecione para alguma página de sucesso ou renderize um novo template
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
        'Email'=> 'Email',
        'Password'=> 'Phone',
    ],
);

