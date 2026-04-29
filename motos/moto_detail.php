<?php
session_start();
$isLoggedIn = isset($_SESSION['user_email']);

require '../config/config.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: /Formulaire/motos/motos.php");
    exit();
}

$id = (int)$_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM motos WHERE id = ?");
$stmt->execute([$id]);
$moto = $stmt->fetch();

if (!$moto) {
    header("Location: /Formulaire/motos/motos.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($moto['marque'] . ' ' . $moto['modele']); ?> — BikePulse</title>
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
        <li><a href="/Formulaire/motos/motos.php" class="active">Fiches</a></li>
        <li><a href="/Formulaire/motos/add_moto.php">Inscription de référence</a></li>
        <li><a href="#">Info &amp; Service</a></li>
    </ul>
    <div class="nav-right">
        <?php if ($isLoggedIn): ?>
            <span class="nav-user"><?php echo htmlspecialchars($_SESSION['user_prenom']); ?></span>
            <a href="/Formulaire/auth/logout.php" class="btn-logout">Déconnexion</a>
        <?php else: ?>
            <a href="/Formulaire/auth/login.php" class="btn-nav-login">Connexion</a>
            <a href="/Formulaire/auth/signup.php" class="btn-logout">Inscription</a>
        <?php endif; ?>
    </div>
</nav>

<section class="detail-section">

    <!-- Bouton retour -->
    <a href="/Formulaire/motos/motos.php" class="btn-back">← Retour aux fiches</a>

    <div class="detail-container">

        <!-- IMAGE -->
        <div class="detail-image-wrap">
            <?php if (!empty($moto['image'])): ?>
                <img src="/Formulaire/uploads/motos/<?php echo htmlspecialchars($moto['image']); ?>"
                     alt="<?php echo htmlspecialchars($moto['marque'] . ' ' . $moto['modele']); ?>"
                     class="detail-image">
            <?php else: ?>
                <div class="detail-placeholder">🏍️</div>
            <?php endif; ?>
        </div>

        <!-- INFOS -->
        <div class="detail-infos">

            <div class="card-tag"><?php echo ucfirst($moto['type']); ?></div>
            <h1 class="detail-title">
                <?php echo htmlspecialchars($moto['marque']); ?><br>
                <span><?php echo htmlspecialchars($moto['modele']); ?></span>
            </h1>

            <?php if ($moto['description']): ?>
                <p class="detail-desc"><?php echo htmlspecialchars($moto['description']); ?></p>
            <?php endif; ?>

            <!-- SPECS -->
            <div class="detail-specs">
                <?php if ($moto['annee']): ?>
                <div class="detail-spec-item">
                    <span class="spec-label">Année</span>
                    <span class="spec-value"><?php echo $moto['annee']; ?></span>
                </div>
                <?php endif; ?>
                <?php if ($moto['cylindree']): ?>
                <div class="detail-spec-item">
                    <span class="spec-label">Cylindrée</span>
                    <span class="spec-value"><?php echo $moto['cylindree']; ?> cm³</span>
                </div>
                <?php endif; ?>
                <?php if ($moto['puissance']): ?>
                <div class="detail-spec-item">
                    <span class="spec-label">Puissance</span>
                    <span class="spec-value"><?php echo $moto['puissance']; ?> ch</span>
                </div>
                <?php endif; ?>
                <div class="detail-spec-item">
                    <span class="spec-label">Type</span>
                    <span class="spec-value"><?php echo ucfirst($moto['type']); ?></span>
                </div>
            </div>

            <?php if ($isLoggedIn): ?>
            <div class="detail-actions">
                <a href="/Formulaire/motos/edit_moto.php?id=<?php echo $moto['id']; ?>" class="btn-save">Modifier</a>
                <a href="/Formulaire/motos/delete_moto.php?id=<?php echo $moto['id']; ?>" class="btn-delete" onclick="return confirm('Supprimer cette moto ?')">Supprimer</a>
            </div>
            <?php endif; ?>

        </div>
    </div>

</section>

</body>
</html>