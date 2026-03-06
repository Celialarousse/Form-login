<?php
// Configuration de la connexion à la base de données MySQL
$host = 'my_mysql';// Adresse du serveur MySQL (dans un environnement Docker, cela correspond au nom du service dans docker-compose.yml)
$db = 'db';// Nom de la base de données à laquelle se connecter
$user = 'root';// Nom d'utilisateur MySQL (par défaut, souvent 'root' en développement)
$pass = 'root123';// Mot de passe MySQL (à ne pas utiliser en production sans sécurisation supplémentaire)
$charset = 'utf8mb4';// Jeu de caractères utilisé pour la connexion (utf8mb4 permet de gérer tous les caractères Unicode, y compris les emojis)
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";// Chaîne de connexion DSN (Data Source Name) pour PDO

// Options de configuration pour PDO
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Active le mode d'erreur pour lancer des exceptions en cas d'erreur SQL
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,      // Définit le mode de récupération par défaut : tableaux associatifs
    PDO::ATTR_EMULATE_PREPARES   => false,                  // Désactive l'émulation des requêtes préparées pour une meilleure sécurité
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);// Création d'une nouvelle instance PDO pour se connecter à la base de données
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());// En cas d'erreur de connexion, lance une exception avec le message et le code d'erreur. Cela permet de gérer les erreurs de manière centralisée dans l'application
}
?>
