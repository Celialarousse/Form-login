<?php
session_start();
require '../config/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $lastname = trim($_POST["nom"]);
    $firstname = trim($_POST["prenom"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    if (empty($lastname) || empty($firstname) || empty($email) || empty($password) || empty($confirm_password)) {
        $_SESSION['registration_error'] = "Tous les champs sont obligatoires.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['registration_error'] = "L'adresse email n'est pas valide.";
    } elseif (strlen($password) < 8) {
        $_SESSION['registration_error'] = "Le mot de passe doit contenir au moins 8 caractères.";
    } elseif ($password !== $confirm_password) {
        $_SESSION['registration_error'] = "Les mots de passe ne correspondent pas.";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        try {
            $stmt = $pdo->prepare("SELECT id FROM utilisateurs WHERE email = ?");
            $stmt->execute([$email]);
            if ($stmt->fetch()) {
                $_SESSION['registration_error'] = "Un compte existe déjà avec cette adresse email.";
            } else {
                $stmt = $pdo->prepare("INSERT INTO utilisateurs (nom, prenom, email, mot_de_passe, is_active) VALUES (?, ?, ?, ?, 1)");
                $stmt->execute([$lastname, $firstname, $email, $hashed_password]);
                $_SESSION['registration_success'] = "Votre compte a bien été créé ! Vous pouvez maintenant vous connecter.";
            }
            header("Location: ../auth/signup.php");
            exit();
        } catch(PDOException $e) {
            $_SESSION['registration_error'] = "Erreur : " . $e->getMessage();
        }
    }
    header("Location: ../auth/signup.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Registration Result</title>
        <link rel="stylesheet" href="../assets/styles.css">
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