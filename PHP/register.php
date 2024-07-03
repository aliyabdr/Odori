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
            echo "Fehler: " . $stmt->errorInfo()[2];
        }
    } catch (PDOException $e) {
        echo "Fehler: " . $e->getMessage();
    }

    $pdo = null; // Verbindung schließen
} else {
    echo "Ungültige Anforderung.";
}
?>
