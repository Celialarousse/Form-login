<?php
session_start();
require '../config/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email    = $_POST["email"];
    $password = $_POST["password"];

    try {
        $stmt = $pdo->prepare("SELECT id, nom, prenom, email, mot_de_passe, is_active FROM utilisateurs WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['mot_de_passe'])) {

            if ($user['is_active'] == 0) {
                $_SESSION['login_error'] = "Votre compte a été désactivé. Contactez le support.";
                header("Location: /Formulaire/auth/login.php");
                exit();
            }

            $_SESSION['user_id']     = $user['id'];
            $_SESSION['user_email']  = $user['email'];
            $_SESSION['user_nom']    = $user['nom'];
            $_SESSION['user_prenom'] = $user['prenom'];
            header("Location: /Formulaire/home.php");
            exit();

        } else {
            $_SESSION['login_error'] = "Email ou mot de passe incorrect.";
            header("Location: /Formulaire/auth/login.php");
            exit();
        }

    } catch (PDOException $e) {
        die("Erreur : " . $e->getMessage());
    }
}

header("Location: /Formulaire/auth/login.php");
exit();
?>