<?php
include '../db_connect.php'; // Verbindung zur Datenbank herstellen

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $plz = $_POST['plz'];
    $ort = $_POST['ort'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password_repeat = $_POST['password_repeat'];

    // Server-seitige Validierung
    if (!preg_match("/^[a-zA-Z0-9]+$/", $username)) {
        die("Benutzername darf nur Buchstaben und Zahlen enthalten.");
    }

    if (!preg_match("/^(?=.*\d)[a-zA-Z\d]{7,}$/", $password)) {
        die("Das Passwort muss mindestens 7 Zeichen lang sein und mindestens eine Zahl enthalten.");
    }

    if ($password !== $password_repeat) {
        die("Die Passwörter stimmen nicht überein.");
    }

    // Das Passwort verschlüsseln
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Benutzer in die Datenbank einfügen
    $sql = "INSERT INTO users (benutzername, passwort, email, plz, standort) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $username, $hashed_password, $email, $plz, $ort);

    if ($stmt->execute()) {
        echo "Registrierung erfolgreich!";
        header('Location: login.php'); // Weiterleitung zur Login-Seite
        exit;
    } else {
        echo "Fehler: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Ungültige Anforderung.";
}
?>
