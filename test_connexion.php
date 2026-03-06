<?php
$host = 'my_mysql'; // Nom du service MySQL dans docker-compose.yml
$db = 'db';
$user = 'root';
$pass = 'root123';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

// Options de configuration pour PDO
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Active le mode d'erreur pour lancer des exceptions en cas d'erreur SQL
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,      // Définit le mode de récupération par défaut : tableaux associatifs
    PDO::ATTR_EMULATE_PREPARES   => false,                  // Désactive l'émulation des requêtes préparées pour une meilleure sécurité
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options); // Création d'une nouvelle instance PDO pour se connecter à la base de données
    echo "Connexion réussie à la base de données !"; // Affiche un message de succès si la connexion est établie

} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode()); // En cas d'erreur de connexion, lance une exception avec le message et le code d'erreur
}
?>