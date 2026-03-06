<?php
session_start();
session_unset(); // Cela efface toutes les données stockées dans la session
session_destroy(); // Cela supprime la session côté serveur

header("Location: connexion.php");
exit();
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Déconnexion</title>
        <link rel="stylesheet" href="styles.css">
    </head>
    <body>
        <div class="welcome-container">
            <h1>Vous êtes déconnecté(e)</h1>
            <p>Merci d'avoir utilisé notre service.</p>
            <p>Vous allez être redirigé(e) vers la page de connexion...</p>
            <meta http-equiv="refresh" content="3;url=connexion.php"> <!-- Cette balise meta rafraîchit la page après 3 secondes et redirige vers la page de connexion -->
        </div>
    </body>
</html>
