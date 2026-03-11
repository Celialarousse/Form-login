<?php
$host = 'my_mysql'; // MySQL service name in docker-compose.yml
$db = 'db';
$user = 'root';
$pass = 'root123';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

// PDO configuration options
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Enable error mode to throw exceptions on SQL errors
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,      // Set default fetch mode: associative arrays
    PDO::ATTR_EMULATE_PREPARES   => false,                  // Disable prepared statement emulation for better security
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options); // Create a new PDO instance to connect to the database
    echo "Successfully connected to the database!"; // Display a success message if the connection is established

} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode()); // In case of connection error, throw an exception with the message and error code
}
?>