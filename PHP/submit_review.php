<?php
session_start();
include 'db.php'; // Verbindet zur Datenbank

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_POST['user_id'];
    $reviewer_id = $_SESSION['user_id'];
    $rating = $_POST['rating'];
    $review = $_POST['review'];

    $stmt = $pdo->prepare("INSERT INTO reviews (user_id, reviewer_id, review, rating) VALUES (?, ?, ?, ?)");
    $stmt->execute([$user_id, $reviewer_id, $review, $rating]);

    header("Location: nutzer_profil.php?user_id=$user_id");
    exit;
} else {
    header("Location: index.php");
    exit;
}
?>
