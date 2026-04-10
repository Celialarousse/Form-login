<?php
session_start();
if (!isset($_SESSION['user_email'])) {
    header("Location: /Formulaire/auth/login.php");
    exit();
}
require '../config/config.php';

// Récupération des motos pour la liste du bas
$stmt = $pdo->query("SELECT * FROM motos ORDER BY id DESC");
$motos = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription de référence — BikePulse</title>
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
        <li><a href="/Formulaire/motos/add_moto.php" class="active">Inscription de référence</a></li>
        <li><a href="#">Info &amp; Service</a></li>
    </ul>
    <div class="nav-right">
        <span class="nav-user"><?php echo htmlspecialchars($_SESSION['user_prenom']); ?></span>
        <a href="/Formulaire/auth/logout.php" class="btn-logout">Déconnexion</a>
    </div>
</nav>

<section class="hero">
    <h1>Inscription de <span>Référence</span></h1>
    <p>Ajoutez, modifiez ou supprimez les motos du catalogue.</p>
</section>

<?php if (isset($_SESSION['crud_error'])): ?>
    <div class="alert alert-danger" style="max-width:1100px;margin:0 auto 20px;padding:0 40px;">
        <?php echo htmlspecialchars($_SESSION['crud_error']); unset($_SESSION['crud_error']); ?>
    </div>
<?php endif; ?>
<?php if (isset($_SESSION['crud_success'])): ?>
    <div class="alert alert-success" style="max-width:1100px;margin:0 auto 20px;padding:0 40px;">
        <?php echo htmlspecialchars($_SESSION['crud_success']); unset($_SESSION['crud_success']); ?>
    </div>
<?php endif; ?>

<!-- FORMULAIRE D'AJOUT -->
<section class="crud-section">
    <div class="crud-header">
        <h2 class="crud-title">Ajouter une moto</h2>
    </div>
    <div class="crud-form-container">
        <form action="/Formulaire/motos/add_moto_process.php" method="post">
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
                <button type="submit" class="btn-save">Enregistrer la moto</button>
            </div>
        </form>
    </div>
</section>

<!-- LISTE DES MOTOS AVEC ACTIONS -->
<section class="cards-section">
    <div class="crud-header" style="margin-bottom:24px;">
        <h2 class="crud-title">Motos enregistrées</h2>
    </div>
    <?php if (empty($motos)): ?>
        <div class="empty-state">
            <p>Aucune moto enregistrée pour l'instant.</p>
        </div>
    <?php else: ?>
        <div class="cards-grid">
            <?php foreach ($motos as $moto): ?>
            <div class="card">
                <div class="card-img-wrap">
                    <div class="card-placeholder moto-placeholder">🏍️</div>
                </div>
                <div class="card-body">
                    <div class="card-tag"><?php echo ucfirst($moto['type']); ?></div>
                    <h2 class="card-title"><?php echo htmlspecialchars($moto['marque'] . ' ' . $moto['modele']); ?></h2>
                    <div class="moto-specs">
                        <?php if ($moto['annee']): ?>
                            <span class="spec"><strong>Année</strong><?php echo $moto['annee']; ?></span>
                        <?php endif; ?>
                        <?php if ($moto['cylindree']): ?>
                            <span class="spec"><strong>Cylindrée</strong><?php echo $moto['cylindree']; ?> cm³</span>
                        <?php endif; ?>
                        <?php if ($moto['puissance']): ?>
                            <span class="spec"><strong>Puissance</strong><?php echo $moto['puissance']; ?> ch</span>
                        <?php endif; ?>
                    </div>
                    <?php if ($moto['description']): ?>
                        <p class="card-desc"><?php echo htmlspecialchars(mb_substr($moto['description'], 0, 100)) . (mb_strlen($moto['description']) > 100 ? '...' : ''); ?></p>
                    <?php endif; ?>
                    <div class="card-actions">
                        <a href="/Formulaire/motos/edit_moto.php?id=<?php echo $moto['id']; ?>" class="btn-edit">Modifier</a>
                        <a href="/Formulaire/motos/delete_moto.php?id=<?php echo $moto['id']; ?>" class="btn-delete" onclick="return confirm('Supprimer cette moto ?')">Supprimer</a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>

</body>
</html>