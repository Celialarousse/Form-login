<?php
// Start a PHP session to access session variables
session_start();

// Check if the user is logged in by verifying the presence of the email in the session
// If the user is not logged in, redirect them to the login page
if (!isset($_SESSION['user_email'])) {
    header("Location: login.php"); // Redirect to the login page
    exit(); // Stop script execution after redirection
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <!-- Makes the page responsive by adapting the width to the device -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Welcome</title>
        <link rel="stylesheet" href="styles.css">
    </head>
    <body>
        <!-- Main container for the page content -->
        <div class="welcome-container">
            <!-- Vérifie que la clé 'user_prenom' existe avant de l'afficher -->
            <h1>Welcome, <?php echo isset($_SESSION['user_prenom']) ? htmlspecialchars($_SESSION['user_prenom']) : 'User'; ?>!</h1>
            <p>You are now logged in.</p> <!-- Login confirmation message -->
            <a href="logout.php" class="logout-btn">Log out</a> <!-- Link to the logout page with a CSS class for styling -->
        </div>
    </body>
</html>