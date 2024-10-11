<?php

session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $mdp = $_POST['mdp'];

    $stmt = $pdo->prepare("SELECT * FROM client WHERE email = ?");
    $stmt->execute([$email]);
    $client = $stmt->fetch();

    if ($client && password_verify($mdp, $client['mdp'])) {
        $_SESSION['clientId'] = $client['clientId'];
        header('Location: tableau_de_bord.php');
    } else {
        echo "Identifiants incorrects";
    }
}
?>
