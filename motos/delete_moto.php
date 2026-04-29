<?php
session_start();
require '../config/config.php';

if (!isset($_SESSION['user_email'])) {
    header("Location: /Formulaire/auth/login.php");
    exit();
}

// On accepte uniquement POST maintenant
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: /Formulaire/motos/add_moto.php");
    exit();
}

// Vérification du token CSRF
if (
    !isset($_POST['csrf_token']) ||
    !isset($_SESSION['csrf_token']) ||
    !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])
) {
    $_SESSION['crud_error'] = "Action non autorisée (token invalide).";
    header("Location: /Formulaire/motos/add_moto.php");
    exit();
}

if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
    header("Location: /Formulaire/motos/add_moto.php");
    exit();
}

$id = (int)$_POST['id'];

try {
    $stmt = $pdo->prepare("SELECT marque, modele, image FROM motos WHERE id = ?");
    $stmt->execute([$id]);
    $moto = $stmt->fetch();

    if (!$moto) {
        $_SESSION['crud_error'] = "Cette moto n'existe pas.";
        header("Location: /Formulaire/motos/add_moto.php");
        exit();
    }

    // Supprimer l'image associée si elle existe
    if (!empty($moto['image'])) {
        $imagePath = '/var/www/html/Formulaire/uploads/motos/' . $moto['image'];
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
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