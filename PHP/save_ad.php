<?php
session_start();
include '../db_connect.php'; // Verbindung zur Datenbank herstellen

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ad_id = $_POST['ad_id'];
    $user_id = $_SESSION['user_id'];

    // Überprüfen, ob die Anzeige bereits gespeichert wurde
    $sql = "SELECT saved_ads FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $saved_ads = explode(',', $user['saved_ads']);

    if (!in_array($ad_id, $saved_ads)) {
        $saved_ads[] = $ad_id;
        $saved_ads_string = implode(',', $saved_ads);

        $sql_update = "UPDATE users SET saved_ads = ? WHERE id = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("si", $saved_ads_string, $user_id);
        $stmt_update->execute();
    }

    header('Location: gespeicherte_anzeigen.php');
    exit();
}

$conn->close();
?>
