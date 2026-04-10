<?php
session_start();

if (!isset($_SESSION['user_email'])) {
    header("Location: ../auth/login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une moto — BikePulse</title>
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
            <h1 class="crud-title">Ajouter une moto</h1>
            <a href="motos.php" class="btn-back">← Retour à la liste</a>
        </div>

        <?php if (isset($_SESSION['crud_error'])): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($_SESSION['crud_error']); unset($_SESSION['crud_error']); ?></div>
        <?php endif; ?>

        <div class="crud-form-container">
            <form action="add_moto_process.php" method="post">

                <div class="form-row">
                    <div class="form-group">
                        <label for="marque">Marque *</label>
                        <input type="text" id="marque" name="marque" placeholder="ex : Honda" required>
                    </div>
                    <div class="form-group">
                        <label for="modele">Modèle *</label>
                        <input type="text" id="modele" name="modele" placeholder="ex : CBR600RR" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="type">Type *</label>
                        <select id="type" name="type" required>
                            <option value="" disabled selected>Choisir un type</option>
                            <option value="roadster">Roadster</option>
                            <option value="sportive">Sportive</option>
                            <option value="trail">Trail</option>
                            <option value="motocross">Motocross</option>
                            <option value="custom">Custom</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="annee">Année</label>
                        <input type="number" id="annee" name="annee" placeholder="ex : 2023" min="1900" max="2099">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="cylindree">Cylindrée (cm³)</label>
                        <input type="number" id="cylindree" name="cylindree" placeholder="ex : 600">
                    </div>
                    <div class="form-group">
                        <label for="puissance">Puissance (ch)</label>
                        <input type="number" id="puissance" name="puissance" placeholder="ex : 120">
                    </div>
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" rows="4" placeholder="Décrivez la moto..."></textarea>
                </div>

                <div class="form-actions">
                    <a href="motos.php" class="btn-back">Annuler</a>
                    <button type="submit" class="btn-save">Enregistrer la moto</button>
                </div>

            </form>
        </div>

    </section>

</body>
</html>