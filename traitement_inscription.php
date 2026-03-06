<?php
session_start();

require 'config.php';

$erreur = ""; // Variable pour stocker les messages d'erreur

// Vérifie si le formulaire a été soumis avec la méthode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupère et nettoie les données soumises par l'utilisateur
    $nom = trim($_POST["username"]);
    $prenom = trim($_POST["prenom"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    // Validation des champs
    if (empty($nom) || empty($prenom) || empty($email) || empty($password) || empty($confirm_password)) {
        $erreur = "Tous les champs sont obligatoires.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erreur = "L'email n'est pas valide.";
    } elseif (strlen($password) < 8) {
        $erreur = "Le mot de passe doit contenir au moins 8 caractères.";
    } elseif ($password !== $confirm_password) {
        $erreur = "Les mots de passe ne correspondent pas.";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        try {
            $stmt = $pdo->prepare("SELECT id FROM utilisateurs WHERE email = ?"); // Vérifie si l'email existe déjà dans la base de données
            $stmt->execute([$email]);

            // Si un utilisateur avec cet email existe déjà
            if ($stmt->fetch()) {
                $erreur = "Un compte existe déjà avec cet email.";
            } else {
                // Insère le nouvel utilisateur dans la base de données
                $stmt = $pdo->prepare("INSERT INTO utilisateurs (nom, prenom, email, mot_de_passe) VALUES (?, ?, ?, ?)");
                $stmt->execute([$nom, $prenom, $email, $hashed_password]);

                $_SESSION['succes_inscription'] = "Votre compte a été créé avec succès ! Vous pouvez maintenant vous connecter."; // Stocke un message de succès en session pour l'afficher sur la page de connexion

                header("Location: connexion.php");
                exit();
            }
        } catch(PDOException $e) {
            $erreur = "Erreur : " . $e->getMessage(); // En cas d'erreur de base de données, stocke le message d'erreur
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Résultat de l'inscription</title>
        <link rel="stylesheet" href="styles.css">
    </head>
    <body>
        <div class="welcome-container">
            <h1>Résultat de l'inscription</h1>
            <?php
            // Affiche un message d'erreur si l'inscription a échoué
            if (!empty($erreur)) {
                echo "<p class='alert alert-danger'>$erreur</p>";
                echo "<a href='inscription.php' class='submit-btn'>Retour à l'inscription</a>";
            }
            ?>
        </div>
    </body>
</html>
