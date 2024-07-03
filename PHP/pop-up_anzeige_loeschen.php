<?php
include '../db_connect.php';

// Überprüfen, ob die ID übergeben wurde
if (isset($_GET['id'])) {
    $ad_id = $_GET['id'];

    try {
        // SQL-Befehl zum Löschen der Anzeige
        $sql = "DELETE FROM ads WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $ad_id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            // Erfolgreich gelöscht, Weiterleitung zur Bestätigungsseite oder Startseite
            header('Location: startseite.php?message=Anzeige erfolgreich gelöscht');
            exit();
        } else {
            echo "Fehler beim Löschen der Anzeige: " . $stmt->errorInfo()[2];
        }
    } catch (PDOException $e) {
        echo "Fehler: " . $e->getMessage();
    }
} else {
    echo "Keine Anzeige ID angegeben.";
}

$pdo = null; // Verbindung schließen
?>
