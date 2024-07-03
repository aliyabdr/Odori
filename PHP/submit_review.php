<?php
session_start();
include 'db.php'; // Verbindet zur Datenbank

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_SESSION['user_id'])) {
        header('Location: login.php');
        exit();
    }

    $user_id = $_POST['user_id'];
    $reviewer_id = $_SESSION['user_id'];
    $rating = $_POST['rating'];
    $review = $_POST['review'];

    try {
        $stmt = $pdo->prepare("INSERT INTO reviews (user_id, reviewer_id, review, rating) VALUES (:user_id, :reviewer_id, :review, :rating)");
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':reviewer_id', $reviewer_id, PDO::PARAM_INT);
        $stmt->bindParam(':review', $review, PDO::PARAM_STR);
        $stmt->bindParam(':rating', $rating, PDO::PARAM_INT);
        $stmt->execute();

        header("Location: nutzer_profil.php?user_id=$user_id");
        exit;
    } catch (PDOException $e) {
        echo "Fehler: " . $e->getMessage();
    }
} else {
    header("Location: index.php");
    exit;
}
?>