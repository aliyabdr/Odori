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

// Abfrage für gespeicherte Anzeigen
$sql_user = "SELECT saved_ads FROM users WHERE id = ?";
$stmt_user = $conn->prepare($sql_user);
$stmt_user->bind_param("i", $user_id);
$stmt_user->execute();
$result_user = $stmt_user->get_result();
$user = $result_user->fetch_assoc();
$stmt_user->close();

$saved_ads = explode(',', $user['saved_ads']);

// Entfernen der Anzeige aus den gespeicherten Anzeigen
$saved_ads = array_filter($saved_ads, function($id) use ($ad_id) {
    return $id != $ad_id;
});

$saved_ads_string = implode(',', $saved_ads);

// Aktualisieren der gespeicherten Anzeigen in der Datenbank
$sql_update = "UPDATE users SET saved_ads = ? WHERE id = ?";
$stmt_update = $conn->prepare($sql_update);
$stmt_update->bind_param("si", $saved_ads_string, $user_id);

if ($stmt_update->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Fehler beim Aktualisieren der Datenbank']);
}

$stmt_update->close();
$conn->close();
?>
