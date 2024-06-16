<?php
$servername = "localhost";
$username = "root"; // Standardbenutzername für XAMPP
$password = ""; // Standardpasswort für XAMPP
$dbname = "kleinanzeigenplattform";

// Verbindung erstellen
$conn = new mysqli($servername, $username, $password, $dbname);

// Verbindung überprüfen
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

