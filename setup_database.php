<?php
$servername = "localhost";
$username = "root";
$password = ""; // Dein MySQL-Passwort, falls vorhanden

// Verbindung erstellen
$conn = new mysqli($servername, $username, $password);

// Verbindung überprüfen
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL-Skript ausführen
$sql = file_get_contents('create_database.sql');

if ($conn->multi_query($sql)) {
    do {
        if ($result = $conn->store_result()) {
            $result->free();
        }
    } while ($conn->next_result());
    echo "Datenbank und Tabellen erfolgreich erstellt!";
} else {
    echo "Fehler beim Erstellen der Datenbank und Tabellen: " . $conn->error;
}

$conn->close();
?>
