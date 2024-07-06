<?php
$host = 'localhost'; // Ihr Datenbank-Host
$db = 'kleinanzeigenplattform'; // Ihr Datenbankname
$user = 'root'; // Ihr Datenbankbenutzername
$pass = ''; // Ihr Datenbankpasswort
$charset = 'utf8mb4'; // Zeichensatz

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    // Fehlerbehandlung: sicheres Logging und Ausgabe einer generischen Fehlermeldung
    error_log($e->getMessage(), 3, '/path/to/error_log_file.log'); // Loggen Sie die Fehlermeldung in eine Datei
    echo "Verbindung zur Datenbank fehlgeschlagen. Bitte versuchen Sie es später erneut.";
}
?>