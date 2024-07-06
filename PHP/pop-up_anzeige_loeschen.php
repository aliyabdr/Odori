<?php
include '../db_connect.php';

// Überprüfen, ob die ID übergeben wurde
if (isset($_GET['id'])) {
    $ad_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

    if ($ad_id === false) {
        echo "Ungültige Anzeige ID.";
        exit();
    }

    try {
        // SQL-Befehl zum Löschen der Anzeige
        $sql = "DELETE FROM ads WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $ad_id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            // Erfolgreich gelöscht, Weiterleitung zur Bestätigungsseite oder Startseite
            header('Location: startseite.php?message=' . urlencode('Anzeige erfolgreich gelöscht'));
            exit();
        } else {
            echo "Fehler beim Löschen der Anzeige: " . htmlspecialchars($stmt->errorInfo()[2], ENT_QUOTES, 'UTF-8');
        }
    } catch (PDOException $e) {
        echo "Fehler: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
    }
} else {
    echo "Keine Anzeige ID angegeben.";
}

$pdo = null; // Verbindung schließen
?>

