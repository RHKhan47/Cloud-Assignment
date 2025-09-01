<?php
// Database configuration file.
// Update these values to match your MySQL setup.
// Default values assume a local database named `quizdb` with user `quizuser` and password `password`.
// The DSN string uses utf8mb4 for full Unicode support.

$host = 'localhost';
$db   = 'quizdb';
$user = 'quizuser';
$pass = 'password';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    // If the connection fails, throw an exception with the error message.
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
