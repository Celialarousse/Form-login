<?php
session_start();
require '../config/config.php';

if (!isset($_SESSION['user_email'])) {
    header("Location: /Formulaire/auth/login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id          = (int)$_POST["id"];
    $marque      = trim($_POST["marque"]);
    $modele      = trim($_POST["modele"]);
    $type        = trim($_POST["type"]);
    $annee       = !empty($_POST["annee"])     ? (int)$_POST["annee"]     : null;
    $cylindree   = !empty($_POST["cylindree"]) ? (int)$_POST["cylindree"] : null;
    $puissance   = !empty($_POST["puissance"]) ? (int)$_POST["puissance"] : null;
    $description = trim($_POST["description"]);

    if (empty($marque) || empty($modele) || empty($type)) {
        $_SESSION['crud_error'] = "Les champs Marque, Modèle et Type sont obligatoires.";
        header("Location: /Formulaire/motos/edit_moto.php?id=$id");
        exit();
    }

    // Récupérer l'ancienne image
    $stmt = $pdo->prepare("SELECT image FROM motos WHERE id = ?");
    $stmt->execute([$id]);
    $ancienne = $stmt->fetch();
    $image = $ancienne['image']; // on garde l'ancienne par défaut

    // Gestion de la nouvelle image si uploadée
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir  = '/var/www/html/Formulaire/uploads/motos/';

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $extension  = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        $allowedExt = ['jpg', 'jpeg', 'png', 'webp'];
        $maxSize    = 5 * 1024 * 1024;

        if (!in_array($extension, $allowedExt)) {
            $_SESSION['crud_error'] = "Format d'image non autorisé. Utilisez JPG, PNG ou WEBP.";
            header("Location: /Formulaire/motos/edit_moto.php?id=$id");
            exit();
        }

        if ($_FILES['image']['size'] > $maxSize) {
            $_SESSION['crud_error'] = "L'image est trop lourde (max 5 Mo).";
            header("Location: /Formulaire/motos/edit_moto.php?id=$id");
            exit();
        }

        $newImage = uniqid('moto_') . '.' . $extension;
        $destPath = $uploadDir . $newImage;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $destPath)) {
            // Supprimer l'ancienne image si elle existe
            if (!empty($ancienne['image']) && file_exists($uploadDir . $ancienne['image'])) {
                unlink($uploadDir . $ancienne['image']);
            }
            $image = $newImage;
        } else {
            $_SESSION['crud_error'] = "Erreur lors de l'upload de l'image.";
            header("Location: /Formulaire/motos/edit_moto.php?id=$id");
            exit();
        }
    }

    try {
        $stmt = $pdo->prepare("UPDATE motos SET marque = ?, modele = ?, type = ?, annee = ?, cylindree = ?, puissance = ?, description = ?, image = ? WHERE id = ?");
        $stmt->execute([$marque, $modele, $type, $annee, $cylindree, $puissance, $description, $image, $id]);
        $_SESSION['crud_success'] = "La moto \"$marque $modele\" a bien été modifiée !";
        header("Location: /Formulaire/motos/add_moto.php");
        exit();
    } catch (PDOException $e) {
        $_SESSION['crud_error'] = "Erreur lors de la modification : " . $e->getMessage();
        header("Location: /Formulaire/motos/edit_moto.php?id=$id");
        exit();
    }
}

header("Location: /Formulaire/motos/add_moto.php");
exit();
?>