<?php
// Start a PHP session to access session variables
// This allows retrieving previously stored error or success messages
session_start();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login</title>
        <link rel="stylesheet" href="../assets/styles.css">
    </head>
    <body>
        <?php
        if (isset($_SESSION['login_error'])) { // Display an error message if login failed
            echo '<div class="alert alert-danger">' . htmlspecialchars($_SESSION['login_error']) . '</div>'; // htmlspecialchars() protects against XSS attacks by escaping special characters
            unset($_SESSION['login_error']); // Remove the message from the session after displaying it
        }

        if (isset($_SESSION['registration_success'])) { // Display a success message if registration was successful
            echo '<div class="alert alert-success">' . htmlspecialchars($_SESSION['registration_success']) . '</div>';
            unset($_SESSION['registration_success']); // Remove the message from the session after displaying it
        }
        ?>

        <!-- Main container for the login form -->
        <div class="form-container">
            <h1>Log in</h1>

            <!-- action="login_process.php": the form sends data to this file for processing -->
            <!-- method="post": data is sent via POST method (more secure than GET) -->
            <form action="login_process.php" method="post">
                <div class="form-group">
                    <label for="email">Email address:</label>
                    <input type="email" id="email" name="email" required>
                </div>

                <div class="form-group">
                    <label for="password">Password:</label>
                    <!-- Container for the password field (can include an icon to show/hide password) -->
                    <div class="password-container">
                        <input type="password" id="password" name="password" required>
                    </div>
                </div>

                <button type="submit" class="submit-btn">Log in</button>

                <p class="signup-link">Don't have an account yet? <a href="signup.php">Sign up</a></p>
            </form>
        </div>
    </body>
</html>