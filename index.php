<?php
session_start();

if (isset($_SESSION['clientId'])) {
    header('Location: php/dashboard.php');
    exit();
}else{
    header('Location: login.php');
    exit();
}
?>

