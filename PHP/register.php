<?php
include '../db_connect.php'; // Verbindung zur Datenbank herstellen

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $postal_code = $_POST['postal_code'];
    $location = $_POST['location'];
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

    // Überprüfen, ob der Benutzername oder die E-Mail bereits existieren
    $sql_check = "SELECT * FROM users WHERE username = ? OR email = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("ss", $username, $email);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        die("Benutzername oder E-Mail ist bereits vergeben.");
    }

    $stmt_check->close();

    // Benutzer in die Datenbank einfügen
    $sql = "INSERT INTO users (username, password, email, postal_code, location) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $username, $hashed_password, $email, $postal_code, $location);

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
