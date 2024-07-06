<?php
session_start();
include '../db_connect.php'; // Verbindung zur Datenbank herstellen

// Überprüfen, ob der Benutzer eingeloggt ist
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Weiterleitung zur Login-Seite, falls nicht eingeloggt
    exit;
}

// Überprüfen, ob die Anzeige-ID gesetzt ist und ein gültiger Integer-Wert ist
if (isset($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
    $ad_id = $_GET['id'];

    // Überprüfen, ob die Anzeige dem aktuellen Benutzer gehört
    $user_id = $_SESSION['user_id'];

    try {
        $sql = "DELETE FROM ads WHERE id = :id AND user_id = :user_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $ad_id, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            // Erfolgreich gelöscht
            header('Location: eigenes_profil.php');
            exit;
        } else {
            // Fehler beim Löschen
            echo "Fehler beim Löschen der Anzeige.";
        }
    } catch (PDOException $e) {
        echo "Error: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
    }
} else {
    echo "Keine gültige Anzeige-ID angegeben.";
}

$pdo = null;
?>


