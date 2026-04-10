<?php
session_start();
$isLoggedIn = isset($_SESSION['user_email']);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - BikePulse</title>
    <link rel="stylesheet" href="assets/styles.css">
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
        <div class="nav-socials">
            <a href="#" aria-label="Instagram">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <rect x="2" y="2" width="20" height="20" rx="5"/><circle cx="12" cy="12" r="5"/>
                    <circle cx="17.5" cy="6.5" r="1" fill="currentColor" stroke="none"/>
                </svg>
            </a>
            <a href="#" aria-label="LinkedIn">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <rect x="2" y="2" width="20" height="20" rx="4"/>
                    <line x1="8" y1="11" x2="8" y2="17"/><line x1="8" y1="8" x2="8" y2="8.5" stroke-width="2.5"/>
                    <path d="M12 11v6M12 14c0-2 6-2 6 1v2"/>
                </svg>
            </a>
            <a href="#" aria-label="X">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.747l7.73-8.835L1.254 2.25H8.08l4.262 5.636zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                </svg>
            </a>
        </div>

        <?php if ($isLoggedIn): ?>
            <span class="nav-user"><?php echo htmlspecialchars($_SESSION['user_prenom']); ?></span>
            <a href="/Formulaire/auth/logout.php" class="btn-logout">Déconnexion</a>
        <?php else: ?>
            <a href="/Formulaire/auth/login.php" class="btn-nav-login">Connexion</a>
            <a href="/Formulaire/auth/signup.php" class="btn-logout">Inscription</a>
        <?php endif; ?>
    </div>
</nav>

<!-- HERO -->
<section class="hero">
    <?php if ($isLoggedIn): ?>
        <h1>Bienvenue,<br><span><?php echo htmlspecialchars($_SESSION['user_prenom']); ?></span></h1>
    <?php else: ?>
        <h1>Bienvenue sur<br><span>BikePulse</span></h1>
    <?php endif; ?>
    <p>Explorez les fiches techniques, comparez les modèles et restez à jour sur l'univers moto.</p>
</section>

<!-- CARDS -->
<section class="cards-section">
    <div class="cards-grid">

        <div class="card">
            <div class="card-img-wrap">
                <div class="card-placeholder p1">🏍️</div>
            </div>
            <div class="card-body">
                <div class="card-tag">Fiche technique</div>
                <h2 class="card-title">Référence</h2>
                <p class="card-desc">De la cylindrée à la puissance, en passant par les performances et les équipements, retrouvez tout ce qu'il faut savoir sur les modèles qui font vibrer la communauté moto.</p>
                <a href="/Formulaire/motos/motos.php" class="card-link">Voir les fiches →</a>
            </div>
        </div>

        <div class="card">
            <div class="card-img-wrap">
                <div class="card-placeholder p2">🏁</div>
            </div>
            <div class="card-body">
                <div class="card-tag">Tout-terrain</div>
                <h2 class="card-title">Motocross</h2>
                <p class="card-desc">De la cylindrée à la suspension, en passant par le poids et la puissance, nous décortiquons chaque détail pour vous aider à choisir la moto qui correspond à votre style de pilotage.</p>
                <a href="/Formulaire/motos/motos.php" class="card-link">Explorer →</a>
            </div>
        </div>

        <div class="card">
            <div class="card-img-wrap">
                <div class="card-placeholder p3">🏎️</div>
            </div>
            <div class="card-body">
                <div class="card-tag">Circuit</div>
                <h2 class="card-title">Moto sur circuit</h2>
                <p class="card-desc">Découvrez les secrets des motos les plus rapides, comparez les technologies embarquées, et optimisez vos réglages pour dominer sur la piste.</p>
                <a href="/Formulaire/motos/motos.php" class="card-link">Découvrir →</a>
            </div>
        </div>

    </div>
</section>

</body>
</html>