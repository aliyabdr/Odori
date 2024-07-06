<?php
include '../db_connect.php'; // Verbindung zur Datenbank herstellen

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Eingabedaten bereinigen und validieren
    $postal_code = filter_input(INPUT_POST, 'postal_code', FILTER_SANITIZE_STRING);
    $location = filter_input(INPUT_POST, 'location', FILTER_SANITIZE_STRING);
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
    $password_repeat = filter_input(INPUT_POST, 'password_repeat', FILTER_SANITIZE_STRING);

    // Server-seitige Validierung
    if (!$email) {
        die("Ungültige E-Mail-Adresse.");
    }

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

    try {
        // Überprüfen, ob der Benutzername oder die E-Mail bereits existieren
        $sql_check = "SELECT * FROM users WHERE username = :username OR email = :email";
        $stmt_check = $pdo->prepare($sql_check);
        $stmt_check->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt_check->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt_check->execute();

        if ($stmt_check->rowCount() > 0) {
            die("Benutzername oder E-Mail ist bereits vergeben.");
        }

        // Benutzer in die Datenbank einfügen
        $sql = "INSERT INTO users (username, password, email, postal_code, location) VALUES (:username, :password, :email, :postal_code, :location)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':password', $hashed_password, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':postal_code', $postal_code, PDO::PARAM_STR);
        $stmt->bindParam(':location', $location, PDO::PARAM_STR);

        if ($stmt->execute()) {
            echo "Registrierung erfolgreich!";
            header('Location: login.php'); // Weiterleitung zur Login-Seite
            exit;
        } else {
            echo "Fehler: " . htmlspecialchars($stmt->errorInfo()[2], ENT_QUOTES, 'UTF-8');
        }
    } catch (PDOException $e) {
        echo "Fehler: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
    }

    $pdo = null; // Verbindung schließen
} else {
    echo "Ungültige Anforderung.";
}
?>

