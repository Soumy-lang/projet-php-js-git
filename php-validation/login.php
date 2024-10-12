<?php
session_start();
require 'db.php';  

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $mdp = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM client WHERE email = ?");
    $stmt->execute([$email]);
    $client = $stmt->fetch();

    if ($client && password_verify($mdp, $client['mdp'])) {
        $_SESSION['clientId'] = $client['clientId'];

        $stmt = $pdo->prepare("SELECT numeroCompte, solde FROM comptebancaire WHERE clientId = ?");
        $stmt->execute([$client['clientId']]);
        $compte = $stmt->fetch();

        if ($compte) {
            $_SESSION['numeroCompte'] = $compte['numeroCompte'];
            $_SESSION['solde'] = $compte['solde'];

            header('Location: ../dashboard.php');
        } else {
            header('Location: ../login.php?message=Erreur : Aucun compte bancaire trouvé pour ce client.');
            exit();
        }
    } else {
        header('Location: ../login.php?message=Identifiants incorrects');
        exit();
    }
}
?>
