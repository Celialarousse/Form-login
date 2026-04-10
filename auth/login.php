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
    <title>Connexion - BikePulse</title>
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

<?php if (isset($_SESSION['login_error'])): ?>
    <div class="alert alert-danger"><?php echo htmlspecialchars($_SESSION['login_error']); unset($_SESSION['login_error']); ?></div>
<?php endif; ?>

<?php if (isset($_SESSION['registration_success'])): ?>
    <div class="alert alert-success"><?php echo htmlspecialchars($_SESSION['registration_success']); unset($_SESSION['registration_success']); ?></div>
<?php endif; ?>

<div class="form-container">
    <h1>Connexion</h1>
    <form action="login_process.php" method="post">
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
        <button type="submit" class="submit-btn">Se connecter</button>
        <p class="signup-link">Pas encore de compte ? <a href="signup.php">S'inscrire</a></p>
    </form>
</div>

</body>
</html>