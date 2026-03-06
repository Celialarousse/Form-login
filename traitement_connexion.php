<?php
session_start();

require 'config.php'; // Inclut le fichier de configuration de la base de données


if ($_SERVER["REQUEST_METHOD"] == "POST") { // Vérifie si le formulaire a été soumis avec la méthode POST
    // Récupère l'email et le mot de passe soumis par l'utilisateur
    $email = $_POST["email"];
    $password = $_POST["password"];

    try {
        $stmt = $pdo->prepare("SELECT id, nom, prenom, email, mot_de_passe FROM utilisateurs WHERE email = ?"); // Prépare une requête SQL pour sélectionner l'utilisateur avec l'email fourni
        $stmt->execute([$email]);
        $user = $stmt->fetch(); // Récupère les résultats de la requête sous forme de tableau associatif

        // Vérifie si un utilisateur a été trouvé et si le mot de passe est correct
        if ($user && password_verify($password, $user['mot_de_passe'])) {
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_nom'] = $user['nom'];
            $_SESSION['user_prenom'] = $user['prenom'];

            header("Location: accueil.php");
            exit();
        } else {
            $_SESSION['erreur_connexion'] = "Email ou mot de passe incorrect."; // Stocke un message d'erreur en session pour l'afficher sur la page de connexion

            header("Location: connexion.php");
            exit();
        }
    } catch(PDOException $e) {
        die("Erreur : " . $e->getMessage()); // En cas d'erreur de base de données, affiche un message d'erreur et arrête le script
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Connexion validée</title>
        <link rel="stylesheet" href="styles.css">
    </head>
    <body>
        <div class="welcome-container">
            <h1>Résultat de la connexion</h1>
            <?php
            // Affiche un message d'erreur si la connexion a échoué
            if (isset($_SESSION['erreur_connexion'])) {
                echo "<p style='color: red;'>" . $_SESSION['erreur_connexion'] . "</p>";
                unset($_SESSION['erreur_connexion']);
                echo "<a href='connexion.php' class='submit-btn'>Réessayer</a>";
            }
            ?>
        </div>
    </body>
</html>