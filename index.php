<?php
session_start();

if (isset($_SESSION['clientId'])) {
    header('Location: dashboard.php');
    exit();
}else{
    header('Location: connexion.php');
    exit();
}
?>

