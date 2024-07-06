<?php
session_start();
include 'db.php'; // Verbindung zur Datenbank herstellen

// Funktion zum Escapen von HTML-Ausgabe
function escape($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_SESSION['user_id'])) {
        header('Location: login.php');
        exit();
    }

    // Eingabedaten bereinigen und validieren
    $user_id = filter_input(INPUT_POST, 'user_id', FILTER_VALIDATE_INT);
    $reviewer_id = $_SESSION['user_id'];
    $rating = filter_input(INPUT_POST, 'rating', FILTER_VALIDATE_INT);
    $review = trim(filter_input(INPUT_POST, 'review', FILTER_SANITIZE_STRING));

    if ($user_id === false || $rating === false || empty($review)) {
        echo "Ungültige Eingaben.";
        exit();
    }

    try {
        $stmt = $pdo->prepare("INSERT INTO reviews (user_id, reviewer_id, review, rating) VALUES (:user_id, :reviewer_id, :review, :rating)");
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':reviewer_id', $reviewer_id, PDO::PARAM_INT);
        $stmt->bindParam(':review', $review, PDO::PARAM_STR);
        $stmt->bindParam(':rating', $rating, PDO::PARAM_INT);
        $stmt->execute();

        header("Location: nutzer_profil.php?user_id=" . escape($user_id));
        exit;
    } catch (PDOException $e) {
        echo "Fehler: " . escape($e->getMessage());
    }
} else {
    header("Location: index.php");
    exit();
}
?>
