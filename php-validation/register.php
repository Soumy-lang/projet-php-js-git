<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $account_type = $_POST['account_type'];
    
    function generateAccountNumber($pdo) {
        do {
            $account_number = rand(10000000, 99999999); 
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM comptebancaire WHERE numeroCompte = ?");
            $stmt->execute([$account_number]);
            $exists = $stmt->fetchColumn();
        } while ($exists > 0); 

        return $account_number;
    }

    $pdo->beginTransaction();
    
    try {
        $account_number = generateAccountNumber($pdo);
        $solde = 0; 

        $stmt = $pdo->prepare("INSERT INTO client (nom, prenom, telephone, email, mdp) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$lastname, $firstname, $phone, $email, $password]);

        $clientId = $pdo->lastInsertId();
        $stmt = $pdo->prepare("INSERT INTO comptebancaire (numeroCompte, solde, typeDeCompte, clientId) VALUES (?, ?, ?, ?)");
        $stmt->execute([$account_number, $solde, $account_type, $clientId]);

        $pdo->commit();
        header('Location: ../index.php');
        exit;

    } catch (PDOException $e) {
        $pdo->rollBack();
        header('Location: ../register.php?message=Erreur lors de l\'enregistrement :'  . $e->getMessage());
        exit;
    }
}
?>
