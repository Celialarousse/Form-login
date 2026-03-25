<?php
session_start();
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $lastname = trim($_POST["lastname"]);
    $firstname = trim($_POST["firstname"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    if (empty($lastname) || empty($firstname) || empty($email) || empty($password) || empty($confirm_password)) {
        $_SESSION['registration_error'] = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['registration_error'] = "The email is not valid.";
    } elseif (strlen($password) < 8) {
        $_SESSION['registration_error'] = "The password must be at least 8 characters long.";
    } elseif ($password !== $confirm_password) {
        $_SESSION['registration_error'] = "The passwords do not match.";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        try {
            $stmt = $pdo->prepare("SELECT id FROM utilisateurs WHERE email = ?");
            $stmt->execute([$email]);
            if ($stmt->fetch()) {
                $_SESSION['registration_error'] = "An account already exists with this email.";
            } else {
                $stmt = $pdo->prepare("INSERT INTO utilisateurs (nom, prenom, email, mot_de_passe, is_active) VALUES (?, ?, ?, ?, 1)");
                $stmt->execute([$lastname, $firstname, $email, $hashed_password]);
                $_SESSION['registration_success'] = "Your account has been successfully created! You can now log in.";
            }
            header("Location: signup.php");
            exit();
        } catch(PDOException $e) {
            $_SESSION['registration_error'] = "Error: " . $e->getMessage();
        }
    }
    header("Location: signup.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Registration Result</title>
        <link rel="stylesheet" href="styles.css">
    </head>
    <body>
        <div class="welcome-container">
            <h1>Registration Result</h1>
            <?php
            // Display an error message if registration failed
            if (!empty($error)) {
                echo "<p class='alert alert-danger'>$error</p>";
                echo "<a href='signup.php' class='submit-btn'>Back to Registration</a>";
            }
            ?>
        </div>
    </body>
</html>