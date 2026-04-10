<?php
session_start();
$isLoggedIn = isset($_SESSION['user_email']);

require '../config/config.php';

$search  = trim($_GET['search'] ?? '');
$type    = $_GET['type'] ?? '';
$sort    = $_GET['sort'] ?? 'id-desc';

$where  = [];
$params = [];

if (!empty($search)) {
    $where[]  = "(marque LIKE ? OR modele LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
}

if (!empty($type)) {
    $where[]  = "type = ?";
    $params[] = $type;
}

$whereSQL = !empty($where) ? "WHERE " . implode(" AND ", $where) : "";

$sortOptions = [
    'id-desc'         => 'id DESC',
    'annee-desc'      => 'annee DESC',
    'annee-asc'       => 'annee ASC',
    'puissance-desc'  => 'puissance DESC',
    'puissance-asc'   => 'puissance ASC',
    'cylindree-desc'  => 'cylindree DESC',
    'cylindree-asc'   => 'cylindree ASC',
];
$orderSQL = $sortOptions[$sort] ?? 'id DESC';

$stmt = $pdo->prepare("SELECT * FROM motos $whereSQL ORDER BY $orderSQL");
$stmt->execute($params);
$motos = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fiches motos — BikePulse</title>
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

<section class="hero">
    <h1>Les <span>Fiches</span></h1>
    <p>Retrouvez toutes les motos, comparez les caractéristiques et trouvez celle qui vous correspond.</p>
</section>

<section class="filters-section">
    <form action="/Formulaire/motos/motos.php" method="get" class="filters-bar">
        <input type="text" name="search" placeholder="🔍 Rechercher une marque ou un modèle..."
               class="filter-search" value="<?php echo htmlspecialchars($search); ?>">
        <select name="type" class="filter-select">
            <option value="">Tous les types</option>
            <option value="roadster"  <?php echo $type === 'roadster'  ? 'selected' : ''; ?>>Roadster</option>
            <option value="sportive"  <?php echo $type === 'sportive'  ? 'selected' : ''; ?>>Sportive</option>
            <option value="trail"     <?php echo $type === 'trail'     ? 'selected' : ''; ?>>Trail</option>
            <option value="motocross" <?php echo $type === 'motocross' ? 'selected' : ''; ?>>Motocross</option>
            <option value="custom"    <?php echo $type === 'custom'    ? 'selected' : ''; ?>>Custom</option>
        </select>
        <select name="sort" class="filter-select">
            <option value="id-desc"        <?php echo $sort === 'id-desc'        ? 'selected' : ''; ?>>Les plus récents</option>
            <option value="annee-desc"     <?php echo $sort === 'annee-desc'     ? 'selected' : ''; ?>>Année (récent → ancien)</option>
            <option value="annee-asc"      <?php echo $sort === 'annee-asc'      ? 'selected' : ''; ?>>Année (ancien → récent)</option>
            <option value="puissance-desc" <?php echo $sort === 'puissance-desc' ? 'selected' : ''; ?>>Puissance (+ → -)</option>
            <option value="puissance-asc"  <?php echo $sort === 'puissance-asc'  ? 'selected' : ''; ?>>Puissance (- → +)</option>
            <option value="cylindree-desc" <?php echo $sort === 'cylindree-desc' ? 'selected' : ''; ?>>Cylindrée (+ → -)</option>
            <option value="cylindree-asc"  <?php echo $sort === 'cylindree-asc'  ? 'selected' : ''; ?>>Cylindrée (- → +)</option>
        </select>
        <button type="submit" class="btn-save">Filtrer</button>
        <?php if (!empty($search) || !empty($type) || $sort !== 'id-desc'): ?>
            <a href="/Formulaire/motos/motos.php" class="btn-back">✕ Réinitialiser</a>
        <?php endif; ?>
    </form>
    <p class="results-count"><?php echo count($motos); ?> moto(s) trouvée(s)</p>
</section>

<section class="cards-section">
    <?php if (empty($motos)): ?>
        <div class="empty-state">
            <p>Aucune moto ne correspond à votre recherche.</p>
            <a href="/Formulaire/motos/motos.php" class="btn-back">Voir toutes les motos</a>
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
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>

</body>
</html>