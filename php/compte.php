<?php

session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $numeroCompte = $_POST['numeroCompte'];
    $solde = $_POST['solde'];
    $typeDeCompte = $_POST['typeDeCompte'];
    $clientId = $_SESSION['clientId'];

    $sql = "INSERT INTO comptebancaire (numeroCompte, solde, typeDeCompte, clientId) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$numeroCompte, $solde, $typeDeCompte, $clientId]);

    header('Location: dashboard.php');
}
?>
