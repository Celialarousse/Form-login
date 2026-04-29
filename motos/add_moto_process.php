<?php
session_start();
require '../config/config.php';

if (!isset($_SESSION['user_email'])) {
    header("Location: /Formulaire/auth/login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $marque      = trim($_POST["marque"]);
    $modele      = trim($_POST["modele"]);
    $type        = trim($_POST["type"]);
    $annee       = !empty($_POST["annee"])     ? (int)$_POST["annee"]     : null;
    $cylindree   = !empty($_POST["cylindree"]) ? (int)$_POST["cylindree"] : null;
    $puissance   = !empty($_POST["puissance"]) ? (int)$_POST["puissance"] : null;
    $description = trim($_POST["description"]);
    $image       = null;

    if (empty($marque) || empty($modele) || empty($type)) {
        $_SESSION['crud_error'] = "Les champs Marque, Modèle et Type sont obligatoires.";
        header("Location: /Formulaire/motos/add_moto.php");
        exit();
    }

    // Gestion de l'image
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '/var/www/html/Formulaire/uploads/motos/';

        // Créer le dossier s'il n'existe pas
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $extension      = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        $allowedExt     = ['jpg', 'jpeg', 'png', 'webp'];
        $maxSize        = 5 * 1024 * 1024; // 5 Mo

        if (!in_array($extension, $allowedExt)) {
            $_SESSION['crud_error'] = "Format d'image non autorisé. Utilisez JPG, PNG ou WEBP.";
            header("Location: /Formulaire/motos/add_moto.php");
            exit();
        }

        if ($_FILES['image']['size'] > $maxSize) {
            $_SESSION['crud_error'] = "L'image est trop lourde (max 5 Mo).";
            header("Location: /Formulaire/motos/add_moto.php");
            exit();
        }

        // Nom unique pour éviter les conflits
        $image    = uniqid('moto_') . '.' . $extension;
        $destPath = $uploadDir . $image;

        if (!move_uploaded_file($_FILES['image']['tmp_name'], $destPath)) {
            $_SESSION['crud_error'] = "Erreur lors de l'upload de l'image.";
            header("Location: /Formulaire/motos/add_moto.php");
            exit();
        }
    }

    try {
        $stmt = $pdo->prepare("INSERT INTO motos (marque, modele, type, annee, cylindree, puissance, description, image) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$marque, $modele, $type, $annee, $cylindree, $puissance, $description, $image]);
        $_SESSION['crud_success'] = "La moto \"$marque $modele\" a bien été ajoutée !";
        header("Location: /Formulaire/motos/add_moto.php");
        exit();
    } catch (PDOException $e) {
        $_SESSION['crud_error'] = "Erreur lors de l'ajout : " . $e->getMessage();
        header("Location: /Formulaire/motos/add_moto.php");
        exit();
    }
}

header("Location: /Formulaire/motos/add_moto.php");
exit();
?>