<?php
session_start();
include '../db_connect.php'; // Verbindung zur Datenbank herstellen

// Überprüfen, ob der Benutzer eingeloggt ist
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Weiterleitung zur Login-Seite, falls nicht eingeloggt
    exit;
}

$user_id = $_SESSION['user_id'];

// Benutzerinformationen aus dem Formular abrufen
$username = $_POST['username'];
$postal_code = $_POST['postal_code'];
$location = $_POST['location'];

// Profilbild hochladen
$profile_picture = $_FILES['profile_picture']['name'];
$target_dir = "../uploads/";
$target_file = $target_dir . basename($profile_picture);
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// Überprüfen, ob die Datei ein Bild ist
if (!empty($profile_picture)) {
    $check = getimagesize($_FILES['profile_picture']['tmp_name']);
    if ($check !== false) {
        // Bilddatei ist ein Bild
        move_uploaded_file($_FILES['profile_picture']['tmp_name'], $target_file);
    } else {
        $profile_picture = ''; // Wenn es kein Bild ist, wird das Profilbild nicht geändert
    }
}

// SQL-Update-Anweisung
if (!empty($profile_picture)) {
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
