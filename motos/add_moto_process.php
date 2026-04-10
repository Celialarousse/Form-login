<?php
session_start();
require '../config/config.php';

if (!isset($_SESSION['user_email'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $marque      = trim($_POST["marque"]);
    $modele      = trim($_POST["modele"]);
    $type        = trim($_POST["type"]);
    $annee       = !empty($_POST["annee"]) ? (int)$_POST["annee"] : null;
    $cylindree   = !empty($_POST["cylindree"]) ? (int)$_POST["cylindree"] : null;
    $puissance   = !empty($_POST["puissance"]) ? (int)$_POST["puissance"] : null;
    $description = trim($_POST["description"]);

    // Validation
    if (empty($marque) || empty($modele) || empty($type)) {
        $_SESSION['crud_error'] = "Les champs Marque, Modèle et Type sont obligatoires.";
        header("Location: ../motos/add_moto.php");
        exit();
    }

    try {
        $stmt = $pdo->prepare("INSERT INTO motos (marque, modele, type, annee, cylindree, puissance, description) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$marque, $modele, $type, $annee, $cylindree, $puissance, $description]);

        $_SESSION['crud_success'] = "La moto \"$marque $modele\" a bien été ajoutée !";
        header("Location: ../motos/motos.php");
        exit();

    } catch (PDOException $e) {
        $_SESSION['crud_error'] = "Erreur lors de l'ajout : " . $e->getMessage();
        header("Location: ../motos/add_moto.php");
        exit();
    }
}

// Accès direct sans POST → retour à la liste
header("Location: ../motos/motos.php");
exit();
?>