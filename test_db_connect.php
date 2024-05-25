<?php
$servername = "localhost";
$username = "root";
$password = ""; // Standardmäßig ist das Passwort leer
$dbname = "kleinanzeigenplattform";

// Verbindung erstellen
$conn = new mysqli($servername, $username, $password, $dbname);

// Verbindung überprüfen
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "Verbindung erfolgreich!";
}

$conn->close();
?>
