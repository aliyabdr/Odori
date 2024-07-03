<?php
session_start();
include '../db_connect.php'; // Verbindung zur Datenbank herstellen

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Nicht eingeloggt']);
    exit;
}

$user_id = $_SESSION['user_id'];
$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['ad_id'])) {
    echo json_encode(['success' => false, 'message' => 'Keine Anzeige-ID angegeben']);
    exit;
}

$ad_id = $data['ad_id'];

try {
    // Abfrage für gespeicherte Anzeigen
    $sql_user = "SELECT saved_ads FROM users WHERE id = :id";
    $stmt_user = $pdo->prepare($sql_user);
    $stmt_user->bindParam(':id', $user_id, PDO::PARAM_INT);
    $stmt_user->execute();
    $user = $stmt_user->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $saved_ads = explode(',', $user['saved_ads']);

        // Entfernen der Anzeige aus den gespeicherten Anzeigen
        $saved_ads = array_filter($saved_ads, function($id) use ($ad_id) {
            return $id != $ad_id;
        });

        $saved_ads_string = implode(',', $saved_ads);

        // Aktualisieren der gespeicherten Anzeigen in der Datenbank
        $sql_update = "UPDATE users SET saved_ads = :saved_ads WHERE id = :id";
        $stmt_update = $pdo->prepare($sql_update);
        $stmt_update->bindParam(':saved_ads', $saved_ads_string, PDO::PARAM_STR);
        $stmt_update->bindParam(':id', $user_id, PDO::PARAM_INT);

        if ($stmt_update->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Fehler beim Aktualisieren der Datenbank']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Benutzer nicht gefunden']);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Fehler: ' . $e->getMessage()]);
}

$pdo = null; // Verbindung schließen
?>
