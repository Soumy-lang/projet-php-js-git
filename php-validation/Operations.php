<?php
session_start();
require 'db.php'; 

if (!isset($_SESSION['clientId'])) {
    header('Location: ../login.php');
    exit();
}

$action = $_GET['action'] ?? '';
$account_number = $_GET['account'] ?? '';

if (empty($account_number)) {
    header('Location: ../dashboard.php?message=Compte non spécifié.');
    exit();
}

// Opération : Dépôt
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $action == 'deposit') {
    $deposit_amount = $_POST['deposit_amount'] ?? 0;

    if ($deposit_amount <= 0) {
        header('Location: ../dashboard.php?message=Le montant du dépôt doit être supérieur à zéro.');
        exit();
    }

    try {
        $stmt = $pdo->prepare("UPDATE comptebancaire SET solde = solde + ? WHERE numeroCompte = ?");
        $stmt->execute([$deposit_amount, $account_number]);

        header('Location: ../dashboard.php?message=Dépôt effectué avec succès.&type=success');
        
        

    } catch (Exception $e) {
        header('Location: ../dashboard.php?message=Erreur lors du dépôt : ' . $e->getMessage());
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $action == 'withdraw') {
    $withdrawal_amount = $_POST['withdrawal_amount'] ?? 0;

    if ($withdrawal_amount <= 0) {
        header('Location: ../dashboard.php?message=Le montant du retrait doit être supérieur à zéro.');
        exit();
    }

    try {
        $stmt = $pdo->prepare("SELECT solde FROM comptebancaire WHERE numeroCompte = ?");
        $stmt->execute([$account_number]);
        $compte = $stmt->fetch();

        if ($compte['solde'] < $withdrawal_amount) {
            header('Location: ../dashboard.php?message=Solde insuffisant pour effectuer le retrait.');
            exit();
        }

        $stmt = $pdo->prepare("UPDATE comptebancaire SET solde = solde - ? WHERE numeroCompte = ?");
        $stmt->execute([$withdrawal_amount, $account_number]);

        header('Location: ../dashboard.php?message=Retrait effectué avec succès.&type=success');

    } catch (Exception $e) {
        header('Location: ../dashboard.php?message=Erreur lors du retrait : ' . $e->getMessage());
    }
}

// Opération : Virement
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $action == 'transfer') {
    $transfer_amount = $_POST['transfer_amount'] ?? 0;
    $recipient_account = $_POST['recipient_account'] ?? '';

    if ($transfer_amount <= 0) {
        header('Location: ../dashboard.php?message=Le montant du virement doit être supérieur à zéro.');
        exit();
    }

    if (empty($recipient_account)) {
        header('Location: ../dashboard.php?message=Aucun compte bénéficiaire sélectionné.');
        exit();
    }

    try {
        $pdo->beginTransaction();

        $stmt = $pdo->prepare("SELECT solde FROM comptebancaire WHERE numeroCompte = ?");
        $stmt->execute([$account_number]);
        $sender = $stmt->fetch();

        if ($sender['solde'] < $transfer_amount) {
            throw new Exception("Erreur : Solde insuffisant pour effectuer le virement.");
        }

        $stmt = $pdo->prepare("SELECT solde FROM comptebancaire WHERE numeroCompte = ?");
        $stmt->execute([$recipient_account]);
        $recipient = $stmt->fetch();

        if (!$recipient) {
            throw new Exception("Erreur : Le compte bénéficiaire n'existe pas.");
        }

        $stmt = $pdo->prepare("UPDATE comptebancaire SET solde = solde - ? WHERE numeroCompte = ?");
        $stmt->execute([$transfer_amount, $account_number]);

        $stmt = $pdo->prepare("UPDATE comptebancaire SET solde = solde + ? WHERE numeroCompte = ?");
        $stmt->execute([$transfer_amount, $recipient_account]);

        $pdo->commit();
        header('Location: ../dashboard.php?message=Virement effectué avec succès.&type=succes');

    } catch (Exception $e) {
        $pdo->rollBack();
        header('Location: ../dashboard.php?message=Erreur lors du virement : ' . $e->getMessage());
    }
}
?>
