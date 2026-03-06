<?php
// Démarre une session PHP pour accéder aux variables de session
session_start();

// Vérifie si l'utilisateur est connecté en vérifiant la présence de l'email en session
// Si l'utilisateur n'est pas connecté, redirige-le vers la page de connexion
if (!isset($_SESSION['user_email'])) {
    header("Location: connexion.php"); // Redirection vers la page de connexion
    exit(); // Arrête l'exécution du script après la redirection
}
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <!-- Rend la page responsive en adaptant la largeur à l'appareil -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Bienvenue</title>
        <link rel="stylesheet" href="styles.css">
    </head>
    <body>
        <!-- Conteneur principal pour le contenu de la page -->
        <div class="welcome-container">
            <h1>Bienvenue, <?php echo htmlspecialchars($_SESSION['user_prenom']); ?> !</h1> <!-- htmlspecialchars() protège contre les attaques XSS en échappant les caractères spéciaux -->
            <p>Vous êtes maintenant connecté(e).</p> <!-- Message de confirmation de connexion -->
            <a href="deconnexion.php" class="deconnexion-btn">Se déconnecter</a> <!-- Lien vers la page de déconnexion avec une classe CSS pour le style -->
        </div>
    </body>
</html>
