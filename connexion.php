<?php
// Démarre une session PHP pour accéder aux variables de session
// Cela permet de récupérer les messages d'erreur ou de succès stockés précédemment
session_start();
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Connexion</title>
        <link rel="stylesheet" href="styles.css">
    </head>
    <body>
        <?php
        if (isset($_SESSION['erreur_connexion'])) { // Affiche un message d'erreur si la connexion a échoué
            echo '<div class="alert alert-danger">' . htmlspecialchars($_SESSION['erreur_connexion']) . '</div>'; // htmlspecialchars() protège contre les attaques XSS en échappant les caractères spéciaux
            unset($_SESSION['erreur_connexion']); // Supprime le message de la session après l'avoir affiché
        }

        if (isset($_SESSION['succes_inscription'])) { // Affiche un message de succès si l'inscription a réussi
            echo '<div class="alert alert-success">' . htmlspecialchars($_SESSION['succes_inscription']) . '</div>';
            unset($_SESSION['succes_inscription']); // Supprime le message de la session après l'avoir affiché
        }
        ?>

        <!-- Conteneur principal pour le formulaire de connexion -->
        <div class="form-container">
            <h1>Se connecter</h1>

            <!-- action="traitement_connexion.php" : le formulaire envoie les données à ce fichier pour traitement -->
            <!-- method="post" : les données sont envoyées via la méthode POST (plus sécurisé que GET) -->
            <form action="traitement_connexion.php" method="post">
                <div class="form-group">
                    <label for="email">Adresse e-mail :</label>
                    <input type="email" id="email" name="email" required>
                </div>

                <div class="form-group">
                    <label for="password">Mot de passe :</label>
                    <!-- Conteneur pour le champ mot de passe (peut contenir une icône pour afficher/masquer le mot de passe) -->
                    <div class="password-container">
                        <input type="password" id="password" name="password" required>
                    </div>
                </div>

                <button type="submit" class="submit-btn">Se connecter</button>

                <p class="signup-link">Pas encore de compte ? <a href="inscription.php">S'inscrire</a></p>
            </form>
        </div>
    </body>
</html>

