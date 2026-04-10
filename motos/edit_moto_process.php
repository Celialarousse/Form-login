<?php
session_start();
require '../config/config.php';

if (!isset($_SESSION['user_email'])) {
    header("Location: ../auth/login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id          = (int)$_POST["id"];
    $marque      = trim($_POST["marque"]);
    $modele      = trim($_POST["modele"]);
    $type        = trim($_POST["type"]);
    $annee       = !empty($_POST["annee"])      ? (int)$_POST["annee"]      : null;
    $cylindree   = !empty($_POST["cylindree"])  ? (int)$_POST["cylindree"]  : null;
    $puissance   = !empty($_POST["puissance"])  ? (int)$_POST["puissance"]  : null;
    $description = trim($_POST["description"]);

    // Validation
    if (empty($marque) || empty($modele) || empty($type)) {
        $_SESSION['crud_error'] = "Les champs Marque, Modèle et Type sont obligatoires.";
        header("Location: edit_moto.php?id=$id");
        exit();
    }

    try {
        $stmt = $pdo->prepare("UPDATE motos SET marque = ?, modele = ?, type = ?, annee = ?, cylindree = ?, puissance = ?, description = ? WHERE id = ?");
        $stmt->execute([$marque, $modele, $type, $annee, $cylindree, $puissance, $description, $id]);

        $_SESSION['crud_success'] = "La moto \"$marque $modele\" a bien été modifiée !";
        header("Location: ../motos/motos.php");
        exit();

    } catch (PDOException $e) {
        $_SESSION['crud_error'] = "Erreur lors de la modification : " . $e->getMessage();
        header("Location: ../moto/edit_moto.php?id=$id");
        exit();
    }
}

header("Location: ../motos/motos.php");
exit();
?>