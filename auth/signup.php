<?php
session_start();
// Si déjà connecté, rediriger vers home
if (isset($_SESSION['user_email'])) {
    header("Location: /Formulaire/home.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - BikePulse</title>
    <link rel="stylesheet" href="../assets/styles.css">
</head>
<body>

<nav>
    <a href="/Formulaire/home.php" class="nav-logo">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="12" y1="2" x2="12" y2="22"/><line x1="2" y1="12" x2="22" y2="12"/>
            <line x1="5" y1="5" x2="19" y2="19"/><line x1="19" y1="5" x2="5" y2="19"/>
        </svg>
        BikePulse
    </a>

    <ul class="nav-links">
        <li><a href="/Formulaire/motos/motos.php">Fiches</a></li>
        <li><a href="/Formulaire/motos/add_moto.php">Inscription de référence</a></li>
        <li><a href="#">Info &amp; Service</a></li>
    </ul>

    <div class="nav-right">
        <a href="/Formulaire/auth/login.php" class="btn-nav-login">Connexion</a>
        <a href="/Formulaire/auth/signup.php" class="btn-logout">Inscription</a>
    </div>
</nav>

<?php if (isset($_SESSION['registration_error'])): ?>
    <div class="alert alert-danger"><?php echo htmlspecialchars($_SESSION['registration_error']); unset($_SESSION['registration_error']); ?></div>
<?php endif; ?>

<?php if (isset($_SESSION['registration_success'])): ?>
    <div class="alert alert-success"><?php echo htmlspecialchars($_SESSION['registration_success']); unset($_SESSION['registration_success']); ?></div>
<?php endif; ?>

<div class="form-container">
    <h1>Créer un compte</h1>
    <form action="signup_process.php" method="post">
        <div class="form-group">
            <label for="nom">Nom :</label>
            <input type="text" id="nom" name="nom" required>
        </div>
        <div class="form-group">
            <label for="prenom">Prénom :</label>
            <input type="text" id="prenom" name="prenom" required>
        </div>
        <div class="form-group">
            <label for="email">Adresse email :</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="password">Mot de passe :</label>
            <div class="password-container">
                <input type="password" id="password" name="password" required>
            </div>
        </div>
        <div class="form-group">
            <label for="confirm_password">Confirmer le mot de passe :</label>
            <div class="password-container">
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>
        </div>
        <button type="submit" class="submit-btn">S'inscrire</button>
        <p class="login-link">Déjà un compte ? <a href="login.php">Se connecter</a></p>
    </form>
</div>

</body>
</html>