<?php
session_start();
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Inscription</title>
        <link rel="stylesheet" href="styles.css">
    </head>
    <body>
        <?php

        if (isset($_SESSION['erreur_inscription'])) { // Affiche un message d'erreur si l'inscription a échoué. Ce message est stocké dans la session lors du traitement de l'inscription
            echo '<div class="alert alert-danger">' . htmlspecialchars($_SESSION['erreur_inscription']) . '</div>'; // htmlspecialchars() protège contre les attaques XSS en échappant les caractères spéciaux
            unset($_SESSION['erreur_inscription']); // Supprime le message de la session après l'avoir affiché
        }

        if (isset($_SESSION['succes_inscription'])) { // Affiche un message de succès si l'inscription a réussi. Ce message est stocké dans la session après une inscription réussie
            echo '<div class="alert alert-success">' . htmlspecialchars($_SESSION['succes_inscription']) . '</div>';
            unset($_SESSION['succes_inscription']); // Supprime le message de la session après l'avoir affiché
        }
        ?>

        <!-- Conteneur principal pour le formulaire d'inscription -->
        <div class="form-container">
            <h1>Créer un compte</h1>

            <form action="traitement_inscription.php" method="post"> <!-- action="traitement_inscription.php" : le formulaire envoie les données à ce fichier pour traitement -->
                <div class="form-group">
                    <label for="username">Nom :</label>
                    <input type="text" id="username" name="username" required>
                </div>

                <div class="form-group">
                    <label for="prenom">Prénom :</label>
                    <input type="text" id="prenom" name="prenom" required>
                </div>

                <div class="form-group">
                    <label for="email">Adresse e-mail :</label>
                    <input type="email" id="email" name="email" required>
                </div>

                <div class="form-group">
                    <label for="password">Mot de passe :</label>
                    <div class="password-container">
                        <input type="password" id="password" name="password" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="confirm_password">Confirmation du mot de passe :</label>
                    <div class="password-container">
                        <input type="password" id="confirm_password" name="confirm_password" required>
                    </div>
                </div>

                <button type="submit" class="submit-btn">S'inscrire</button>

                <p class="login-link">Déjà un compte ? <a href="connexion.php">Se connecter</a></p>
            </form>
        </div>
    </body>
</html>