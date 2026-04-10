<?php
session_start();

if (!isset($_SESSION['user_email'])) {
    header("Location: ../auth/login.php");
    exit();
}

require '../config/config.php';

// Vérifier que l'id est présent dans l'URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: ../motos/motos.php");
    exit();
}

$id = (int)$_GET['id'];

// Récupérer la moto à modifier
$stmt = $pdo->prepare("SELECT * FROM motos WHERE id = ?");
$stmt->execute([$id]);
$moto = $stmt->fetch();

// Si la moto n'existe pas → retour à la liste
if (!$moto) {
    header("Location: ../motos/motos.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier une moto — BikePulse</title>
    <link rel="stylesheet" href="../assets/styles.css">
</head>
<body>

    <!-- NAVBAR -->
    <nav>
        <a href="home.php" class="nav-logo">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="2" x2="12" y2="22"/><line x1="2" y1="12" x2="22" y2="12"/>
                <line x1="5" y1="5" x2="19" y2="19"/><line x1="19" y1="5" x2="5" y2="19"/>
            </svg>
            BikePulse
        </a>

        <ul class="nav-links">
            <li><a href="motos.php">Fiches</a></li>
            <li><a href="#">Inscription de référence</a></li>
            <li><a href="#">Info &amp; Service</a></li>
        </ul>

        <div class="nav-right">
            <span class="nav-user">
                <?php echo isset($_SESSION['user_prenom']) ? htmlspecialchars($_SESSION['user_prenom']) : 'Utilisateur'; ?>
            </span>
            <a href="logout.php" class="btn-logout">Déconnexion</a>
        </div>
    </nav>

    <!-- CONTENU -->
    <section class="crud-section">

        <div class="crud-header">
            <h1 class="crud-title">Modifier une moto</h1>
            <a href="motos.php" class="btn-back">← Retour à la liste</a>
        </div>

        <?php if (isset($_SESSION['crud_error'])): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($_SESSION['crud_error']); unset($_SESSION['crud_error']); ?></div>
        <?php endif; ?>

        <div class="crud-form-container">
            <form action="edit_moto_process.php" method="post">

                <!-- ID caché pour savoir quelle moto modifier -->
                <input type="hidden" name="id" value="<?php echo $moto['id']; ?>">

                <div class="form-row">
                    <div class="form-group">
                        <label for="marque">Marque *</label>
                        <input type="text" id="marque" name="marque" value="<?php echo htmlspecialchars($moto['marque']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="modele">Modèle *</label>
                        <input type="text" id="modele" name="modele" value="<?php echo htmlspecialchars($moto['modele']); ?>" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="type">Type *</label>
                        <select id="type" name="type" required>
                            <option value="roadster"  <?php echo $moto['type'] === 'roadster'  ? 'selected' : ''; ?>>Roadster</option>
                            <option value="sportive"  <?php echo $moto['type'] === 'sportive'  ? 'selected' : ''; ?>>Sportive</option>
                            <option value="trail"     <?php echo $moto['type'] === 'trail'     ? 'selected' : ''; ?>>Trail</option>
                            <option value="motocross" <?php echo $moto['type'] === 'motocross' ? 'selected' : ''; ?>>Motocross</option>
                            <option value="custom"    <?php echo $moto['type'] === 'custom'    ? 'selected' : ''; ?>>Custom</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="annee">Année</label>
                        <input type="number" id="annee" name="annee" value="<?php echo htmlspecialchars($moto['annee'] ?? ''); ?>" min="1900" max="2099">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="cylindree">Cylindrée (cm³)</label>
                        <input type="number" id="cylindree" name="cylindree" value="<?php echo htmlspecialchars($moto['cylindree'] ?? ''); ?>">
                    </div>
                    <div class="form-group">
                        <label for="puissance">Puissance (ch)</label>
                        <input type="number" id="puissance" name="puissance" value="<?php echo htmlspecialchars($moto['puissance'] ?? ''); ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" rows="4"><?php echo htmlspecialchars($moto['description'] ?? ''); ?></textarea>
                </div>

                <div class="form-actions">
                    <a href="motos.php" class="btn-back">Annuler</a>
                    <button type="submit" class="btn-save">Enregistrer les modifications</button>
                </div>

            </form>
        </div>

    </section>

</body>
</html>