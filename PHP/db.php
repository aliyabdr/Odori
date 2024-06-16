<?php
$host = 'localhost'; // Datenbank-Host, normalerweise 'localhost'
$db = 'kleinanzeigenplattform'; // Name der Datenbank
$user = 'root'; // Datenbank-Benutzername, standardmäßig 'root' für XAMPP
$pass = ''; // Datenbank-Passwort, standardmäßig leer für XAMPP
$charset = 'utf8mb4'; // Zeichensatz

// Data Source Name
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

// PDO Optionen
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    // Erstelle ein neues PDO-Objekt
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    // Fehlerbehandlung
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
?>
