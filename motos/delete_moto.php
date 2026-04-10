<?php
session_start();
require '../config/config.php';

if (!isset($_SESSION['user_email'])) {
    header("Location: /Formulaire/auth/login.php");
    exit();
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: /Formulaire/motos/add_moto.php");
    exit();
}

$id = (int)$_GET['id'];

try {
    $stmt = $pdo->prepare("SELECT marque, modele FROM motos WHERE id = ?");
    $stmt->execute([$id]);
    $moto = $stmt->fetch();

    if (!$moto) {
        $_SESSION['crud_error'] = "Cette moto n'existe pas.";
        header("Location: /Formulaire/motos/add_moto.php");
        exit();
    }

    $stmt = $pdo->prepare("DELETE FROM motos WHERE id = ?");
    $stmt->execute([$id]);
    $_SESSION['crud_success'] = "La moto \"{$moto['marque']} {$moto['modele']}\" a bien été supprimée.";

} catch (PDOException $e) {
    $_SESSION['crud_error'] = "Erreur lors de la suppression : " . $e->getMessage();
}

header("Location: /Formulaire/motos/add_moto.php");
exit();
?>