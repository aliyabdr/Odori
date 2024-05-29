<?php
include '../db_connect.php';

// Überprüfen, ob die ID übergeben wurde
if (isset($_GET['id'])) {
    $ad_id = $_GET['id'];

    // SQL-Befehl zum Löschen der Anzeige
    $sql = "DELETE FROM ads WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $ad_id);

    if ($stmt->execute()) {
        // Erfolgreich gelöscht, Weiterleitung zur Bestätigungsseite oder Startseite
        header('Location: startseite.php?message=Anzeige erfolgreich gelöscht');
        exit();
    } else {
        echo "Fehler beim Löschen der Anzeige: " . $conn->error;
    }

    $stmt->close();
} else {
    echo "Keine Anzeige ID angegeben.";
}

$conn->close();
?>
