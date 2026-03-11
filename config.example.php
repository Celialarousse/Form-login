<?php
// Configuration de la connexion à la base de données MySQL
// COPIE CE FICHIER EN `config.php` ET RENSEIGNE TES VALEURS LOCALES

$host = 'ton_hote_mysql'; // Remplace par l’adresse de ton serveur MySQL (ex: 'my_mysql' pour Docker)
$db   = 'nom_de_ta_base';  // Remplace par le nom de ta base de données
$user = 'ton_utilisateur'; // Remplace par ton utilisateur MySQL (ex: 'root' en développement)
$pass = 'ton_mot_de_passe'; // Remplace par ton mot de passe MySQL (ne pas utiliser 'root123' en production !)
$charset = 'utf8mb4';      // Jeu de caractères (utf8mb4 recommandé pour Unicode/emojis)
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

// Options de configuration pour PDO
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,  // Mode d'erreur : exceptions
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Récupération par défaut : tableaux associatifs
    PDO::ATTR_EMULATE_PREPARES   => false,                   // Désactive l'émulation des requêtes préparées
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options); // Connexion à la base de données
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode()); // Gestion des erreurs
}
?>
