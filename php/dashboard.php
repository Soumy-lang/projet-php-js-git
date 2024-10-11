<?php

session_start();
require 'db.php';

if (!isset($_SESSION['clientId'])) {
    header('Location: index.php');
    exit();
}

$clientId = $_SESSION['clientId'];

$stmt = $pdo->prepare("SELECT * FROM comptebancaire WHERE clientId = ?");
$stmt->execute([$clientId]);
$comptes = $stmt->fetchAll();

?>


<h1>Tableau de bord</h1>
<p>Bienvenue !</p> 

<h2>Vos comptes bancaires</h2>
<ul>
    <?php foreach ($comptes as $compte) : ?>
        <li><?= $compte['numeroCompte'] ?> - Solde : <?= $compte['solde'] ?> EUR</li>
    <?php endforeach; ?>
</ul>

<a href="operations.php">Effectuer une opération</a>
<a href="../deconnexion.php">Se déconnecter</a>
