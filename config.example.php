<?php
// MySQL database connection configuration
// COPY THIS FILE TO `config.php` AND FILL IN YOUR LOCAL VALUES

$host = 'your_mysql_host'; // Replace with your MySQL server address (e.g., 'my_mysql' for Docker)
$db   = 'your_database_name';  // Replace with your database name
$user = 'your_username'; // Replace with your MySQL username (e.g., 'root' for development)
$pass = 'your_password'; // Replace with your MySQL password (do not use 'root123' in production!)
$charset = 'utf8mb4';      // Character set (utf8mb4 recommended for Unicode/emojis)
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

// PDO configuration options
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,  // Error mode: exceptions
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Default fetch mode: associative arrays
    PDO::ATTR_EMULATE_PREPARES   => false,                   // Disable prepared statement emulation
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options); // Database connection
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode()); // Error handling
}
?>
