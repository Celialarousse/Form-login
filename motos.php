<?php
session_start();

if (!isset($_SESSION['user_email'])) {
    header('Location: login.php');
    exit();
}

require 'config.php';

//Récupération de toute les motos
$stmt = $pdo->query('SELECT * FROM motos ORDER BY date_ajout DESC');
$motos = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Motos - BikePulse</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <!-- Barre de navigation -->
    <nav class="navbar">
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
            <li><a href="#">Info & Service</a></li>
        </ul>

        <div class="nav-right">
            <span class="nav-user">
                <?php echo isset($_SESSION['user_prenom']) ? htmlspecialchars($_SESSION['user_prenom']) : 'Utilisateur'; ?>
            </span>
        </div>
        <a href="logout.php" class="btn-logout">Déconnexion</a>
    </nav>

    <!--² Contenu principal -->
    <section class="crud-section">
        <div class="crud-header">
            <h1 class="crud-header">Les Motos</h1>
            <a href="add_moto.php" class="btn-add">Ajouter une Moto</a>
        </div>

        <?php if (isset($_SESSION['crud_success'])): ?>
        <div class="alert alert-success"><?php echo htmlspecialchars($_SESSION['crud_success']); unset($_SESSION['crud_success']); ?></div>
        <?php endif; ?>

        <?php if (empty($motos)): ?>
            <div class="empty-state">
                <p>Aucune moto enregistrée pour le moment.</p>
                <a href="add_moto.php" class="btn-add">Ajouter la première moto</a>
            </div>
        <?php else: ?>
            <div class="table-wrap">
                <table class="crud-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Marque</th>
                            <th>Modèle</th>
                            <th>Type</th>
                            <th>Cylindrée</th>
                            <th>Puissance</th>
                            <th>Année</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($motos as $moto): ?>
                        <tr>
                            <td><?php echo $moto['id']; ?></td>
                            <td><strong><?php echo htmlspecialchars($moto['marque']); ?></strong></td>
                            <td><?php echo htmlspecialchars($moto['modele']); ?></td>
                            <td><span class="badge badge-<?php echo $moto['type']; ?>"><?php echo ucfirst($moto['type']); ?></span></td>
                            <td><?php echo $moto['cylindree'] ? $moto['cylindree'] . ' cm³' : '—'; ?></td>
                            <td><?php echo $moto['puissance'] ? $moto['puissance'] . ' ch' : '—'; ?></td>
                            <td><?php echo $moto['annee'] ?? '—'; ?></td>
                            <td class="actions">
                                <a href="edit_moto.php?id=<?php echo $moto['id']; ?>" class="btn-edit">Modifier</a>
                                <a href="delete_moto.php?id=<?php echo $moto['id']; ?>" class="btn-delete" onclick="return confirm('Supprimer cette moto ?')">Supprimer</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>

    </section>

</body>
</html>
