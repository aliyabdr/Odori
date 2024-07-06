<?php
session_start();
include '../db_connect.php'; // Verbindung zur Datenbank herstellen

// Funktion zum Escapen von HTML-Ausgabe
function escape($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

// Überprüfen, ob der Benutzer eingeloggt ist
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Weiterleitung zur Login-Seite, falls nicht eingeloggt
    exit;
}

$user_id = $_SESSION['user_id'];

// Eingabedaten validieren und bereinigen
$username = trim($_POST['username']);
$postal_code = trim($_POST['postal_code']);
$location = trim($_POST['location']);

// Eingabedaten überprüfen
if (empty($username) || empty($postal_code) || empty($location)) {
    echo "Alle Felder sind erforderlich.";
    exit;
}

// Profilbild hochladen
$profile_picture = $_FILES['profile_picture']['name'];
$target_dir = "../uploads/";
$imageFileType = strtolower(pathinfo($profile_picture, PATHINFO_EXTENSION));

// Überprüfen, ob die Datei ein Bild ist und eine gültige Dateiendung hat
$allowed_file_types = ['jpg', 'jpeg', 'png', 'gif'];
if (!empty($profile_picture) && in_array($imageFileType, $allowed_file_types)) {
    $check = getimagesize($_FILES['profile_picture']['tmp_name']);
    if ($check !== false) {
        // Bilddatei ist ein Bild
        $new_filename = uniqid() . '.' . $imageFileType;
        $target_file = $target_dir . $new_filename;
        if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $target_file)) {
            // SQL-Update-Anweisung mit Profilbild
            $sql = "UPDATE users SET username = :username, postal_code = :postal_code, location = :location, profile_picture = :profile_picture WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':username' => $username,
                ':postal_code' => $postal_code,
                ':location' => $location,
                ':profile_picture' => $target_file,
                ':id' => $user_id
            ]);
        } else {
            echo "Fehler beim Hochladen des Bildes.";
            exit;
        }
    } else {
        echo "Die Datei ist kein gültiges Bild.";
        exit;
    }
} else {
    // SQL-Update-Anweisung ohne Profilbild
    $sql = "UPDATE users SET username = :username, postal_code = :postal_code, location = :location WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':username' => $username,
        ':postal_code' => $postal_code,
        ':location' => $location,
        ':id' => $user_id
    ]);
}

if ($stmt->rowCount() > 0) {
    // Erfolgreich aktualisiert
    header('Location: eigenes_profil.php');
} else {
    // Fehler bei der Aktualisierung
    echo "Fehler beim Aktualisieren des Profils.";
}
?>

