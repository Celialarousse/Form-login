<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Sign Up</title>
        <link rel="stylesheet" href="../assets/styles.css">
    </head>
    <body>
        <?php
        if (isset($_SESSION['registration_error'])) { // Display an error message if registration failed. This message is stored in the session during registration processing
            echo '<div class="alert alert-danger">' . htmlspecialchars($_SESSION['registration_error']) . '</div>'; // htmlspecialchars() protects against XSS attacks by escaping special characters
            unset($_SESSION['registration_error']); // Remove the message from the session after displaying it
        }

        if (isset($_SESSION['registration_success'])) { // Display a success message if registration was successful. This message is stored in the session after a successful registration
            echo '<div class="alert alert-success">' . htmlspecialchars($_SESSION['registration_success']) . '</div>';
            unset($_SESSION['registration_success']); // Remove the message from the session after displaying it
        }
        ?>

        <!-- Main container for the registration form -->
        <div class="form-container">
            <h1>Create an account</h1>

            <form action="signup_process.php" method="post"> <!-- action="signup_process.php": the form sends data to this file for processing -->
                <div class="form-group">
                    <label for="nom">Last name:</label>
                    <input type="text" id="nom" name="nom" required>
                </div>

                <div class="form-group">
                    <label for="prenom">First name:</label>
                    <input type="text" id="prenom" name="prenom" required>
                </div>

                <div class="form-group">
                    <label for="email">Email address:</label>
                    <input type="email" id="email" name="email" required>
                </div>

                <div class="form-group">
                    <label for="password">Password:</label>
                    <div class="password-container">
                        <input type="password" id="password" name="password" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="confirm_password">Confirm password:</label>
                    <div class="password-container">
                        <input type="password" id="confirm_password" name="confirm_password" required>
                    </div>
                </div>

                <button type="submit" class="submit-btn">Sign up</button>

                <p class="login-link">Already have an account? <a href="login.php">Log in</a></p>
            </form>
        </div>
    </body>
</html>