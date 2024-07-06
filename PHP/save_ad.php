<?php
session_start();
include '../db_connect.php'; // Verbindung zur Datenbank herstellen

// Funktion zum Escapen von HTML-Ausgabe
function escape($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Eingabedaten bereinigen und validieren
    $ad_id = filter_input(INPUT_POST, 'ad_id', FILTER_VALIDATE_INT);
    $user_id = $_SESSION['user_id'];

    if ($ad_id === false) {
        echo "Ungültige Anzeige-ID.";
        exit();
    }

    try {
        // Überprüfen, ob die Anzeige bereits gespeichert wurde
        $sql = "SELECT saved_ads FROM users WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        $saved_ads = explode(',', $user['saved_ads']);

        if (!in_array($ad_id, $saved_ads)) {
            $saved_ads[] = $ad_id;
            $saved_ads_string = implode(',', $saved_ads);

            $sql_update = "UPDATE users SET saved_ads = :saved_ads WHERE id = :id";
            $stmt_update = $pdo->prepare($sql_update);
            $stmt_update->bindParam(':saved_ads', $saved_ads_string, PDO::PARAM_STR);
            $stmt_update->bindParam(':id', $user_id, PDO::PARAM_INT);
            $stmt_update->execute();
        }

        header('Location: gespeicherte_anzeigen.php');
        exit();
    } catch (PDOException $e) {
        echo "Fehler: " . escape($e->getMessage());
    }

    $pdo = null; // Verbindung schließen
}
?>


