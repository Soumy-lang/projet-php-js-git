<?php
session_start();
require 'php-validation/db.php';

if (!isset($_SESSION['clientId'])) {
    header('Location: login.php'); 
    exit();
}

$account_number = $_SESSION['numeroCompte'];

// Récupérer tous les comptes bancaires sauf celui de l'utilisateur connecté
$stmt = $pdo->prepare("SELECT a.numeroCompte as recipient_account, b.nom as recipient_firstname, b.prenom as recipient_lastname 
    FROM comptebancaire a INNER JOIN client b on a.clientId = b.clientId  WHERE a.numeroCompte != ?");
$stmt->execute([$account_number]);
$comptes = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Récupérer le solde
$sql = $pdo->prepare("SELECT solde FROM comptebancaire WHERE numeroCompte = ?");
$sql->execute([$account_number]);
$balance = $sql->fetch(PDO::FETCH_ASSOC);

if ($balance && isset($balance['solde'])) {
    $formatted_balance = number_format($balance['solde'], 2, ',', ' ');
} else {
    $formatted_balance = "N/A"; 
}
?>

<!DOCTYPE html>
<html lang="fr">
    <?php include "head.php"; ?>
    <main>
        <section class="title">
            <h1>Tableau de bord</h1>
            <a href="logout.php">Deconnexion</a>
        </section>
    </main>
    <body>
        <div class="alert" id="alert">
            <?php if(isset($_GET['message'])): ?>
                <?= htmlspecialchars($_GET['message']); ?>
            <?php endif; ?>
        </div><br>

        <section class="number">Numéro de compte : <?= htmlspecialchars($account_number); ?></section>
        <section class="balance">Solde : <?= $formatted_balance; ?> €</section>

        <div class="container">
            <div class="form-section">
                <h3>Dépôts</h3>
                <form id="deposit-form" action="php-validation/Operations.php?action=deposit&account=<?= htmlspecialchars($account_number); ?>" method="POST">
                    <label for="deposit-amount">Montant du dépôt :</label>
                    <input type="number" id="deposit-amount" name="deposit_amount" placeholder="Entrez le montant à déposer" required>
                    <button type="submit">Déposer</button>
                </form>
            </div>

            <!-- Section Retraits -->
            <div class="form-section">
                <h3>Retraits</h3>
                <form id="withdrawal-form" action="php-validation/Operations.php?action=withdraw&account=<?= htmlspecialchars($account_number); ?>" method="POST">
                    <label for="withdrawal-amount">Montant du retrait :</label>
                    <input type="number" id="withdrawal-amount" name="withdrawal_amount" placeholder="Entrez le montant à retirer" required>
                    <button type="submit">Retirer</button>
                </form>
            </div>

            <!-- Section Virements -->
            <div class="form-section">
            <h3>Virements</h3>
                <form id="transfer-form" action="php-validation/Operations.php?action=transfer&account=<?= htmlspecialchars($account_number); ?>" method="POST">
                    <label for="transfer-amount">Montant du virement :</label>
                    <input type="number" id="transfer-amount" name="transfer_amount" placeholder="Entrez le montant à virer" required>

                    <label for="recipient-account">Sélectionnez un compte bénéficiaire :</label>
                    <select id="recipient-account" name="recipient_account" required>
                        <option value="" disabled selected>Choisissez un compte</option>

                        <!-- Boucle pour afficher les comptes bénéficiaires dans le select -->
                        <?php foreach ($comptes as $compte): ?>
                            <option value="<?= htmlspecialchars($compte['recipient_account']); ?>">
                                <?= htmlspecialchars($compte['recipient_firstname']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                    <button type="submit">Effectuer le virement</button>
                </form>
            </div>
        </div>
    </body>
</html>
