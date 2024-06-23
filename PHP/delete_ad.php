<?php
session_start();
include '../db_connect.php'; // Verbindung zur Datenbank herstellen

// Überprüfen, ob der Benutzer eingeloggt ist
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Weiterleitung zur Login-Seite, falls nicht eingeloggt
    exit;
}

// Überprüfen, ob die Anzeige-ID gesetzt ist
if (isset($_GET['id'])) {
    $ad_id = $_GET['id'];

    // Überprüfen, ob die Anzeige dem aktuellen Benutzer gehört
    $user_id = $_SESSION['user_id'];
    $sql = "DELETE FROM ads WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $ad_id, $user_id);

    if ($stmt->execute()) {
        // Erfolgreich gelöscht
        header('Location: eigenes_profil.php');
    } else {
        // Fehler beim Löschen
        echo "Fehler beim Löschen der Anzeige: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Keine Anzeige-ID angegeben.";
}

$conn->close();
?>
