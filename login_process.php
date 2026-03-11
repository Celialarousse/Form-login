<?php
session_start();

require 'config.php'; // Include the database configuration file

if ($_SERVER["REQUEST_METHOD"] == "POST") { // Check if the form was submitted using the POST method
    // Retrieve the email and password submitted by the user
    $email = $_POST["email"];
    $password = $_POST["password"];

    try {
        $stmt = $pdo->prepare("SELECT id, nom, prenom, email, mot_de_passe FROM utilisateurs WHERE email = ?");
        // Prepare a SQL query to select the user with the provided email
        $stmt->execute([$email]);
        $user = $stmt->fetch(); // Fetch the query results as an associative array

        // Check if a user was found and if the password is correct
        if ($user && password_verify($password, $user['mot_de_passe'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_nom'] = $user['nom'];
            $_SESSION['user_prenom'] = $user['prenom'];
            header("Location: home.php");
            exit();
        } else {
            // Store an error message in the session to display on the login page
            $_SESSION['login_error'] = "Incorrect email or password.";
            header("Location: login.php");
            exit();
        }
    } catch(PDOException $e) {
        // In case of a database error, display an error message and stop the script
        die("Error: " . $e->getMessage());
    }
}
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login Result</title>
        <link rel="stylesheet" href="styles.css">
    </head>
    <body>
        <div class="welcome-container">
            <h1>Login Result</h1>
            <?php
            // Display an error message if the login failed
            if (isset($_SESSION['login_error'])) {
                echo "<p style='color: red;'>" . $_SESSION['login_error'] . "</p>";
                unset($_SESSION['login_error']);
                echo "<a href='login.php' class='submit-btn'>Try again</a>";
            }
            ?>
        </div>
    </body>
</html>