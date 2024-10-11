<?php

session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $typeOperation = $_POST['typeOperation'];
    $montant = $_POST['montant'];
    $compteId = $_POST['compteId'];

    // Récupérer le solde actuel
    $stmt = $pdo->prepare("SELECT solde FROM comptebancaire WHERE compteId = ?");
    $stmt->execute([$compteId]);
    $compte = $stmt->fetch();

    if ($typeOperation == 'depot') {
        $nouveauSolde = $compte['solde'] + $montant;
    } elseif ($typeOperation == 'retrait' && $compte['solde'] >= $montant) {
        $nouveauSolde = $compte['solde'] - $montant;
    } else {
        echo "Opération non autorisée (solde insuffisant)";
        exit();
    }

    // Mettre à jour le solde
    $stmt = $pdo->prepare("UPDATE comptebancaire SET solde = ? WHERE compteId = ?");
    $stmt->execute([$nouveauSolde, $compteId]);

    header('Location: tableau_de_bord.php');
}
?>

<form method="POST" action="operations.php">
    <select name="compteId">
        <?php foreach ($comptes as $compte) : ?>
            <option value="<?= $compte['compteId'] ?>"><?= $compte['numeroCompte'] ?> - Solde : <?= $compte['solde'] ?> EUR</option>
        <?php endforeach; ?>
    </select>
    <input type="number" name="montant" placeholder="Montant" required>
    <select name="typeOperation">
        <option value="depot">Dépôt</option>
        <option value="retrait">Retrait</option>
    </select>
    <button type="submit">Valider</button>
</form>
