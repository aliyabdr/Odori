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
    $sql = "UPDATE users SET username = ?, postal_code = ?, location = ?, profile_picture = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssi", $username, $postal_code, $location, $target_file, $user_id);
} else {
    $sql = "UPDATE users SET username = ?, postal_code = ?, location = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $username, $postal_code, $location, $user_id);
}

if ($stmt->execute()) {
    // Erfolgreich aktualisiert
    header('Location: eigenes_profil.php');
} else {
    // Fehler bei der Aktualisierung
    echo "Fehler beim Aktualisieren des Profils: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>

