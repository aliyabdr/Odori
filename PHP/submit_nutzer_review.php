<?php
session_start();
include 'db.php'; // Verbindet zur Datenbank

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];
    $reviewer_id = $_SESSION['user_id'];
    $rating = $_POST['rating'];
    $review = $_POST['review'];

    $stmt = $pdo->prepare("INSERT INTO reviews (user_id, reviewer_id, rating, review) VALUES (?, ?, ?, ?)");
    $stmt->execute([$user_id, $reviewer_id, $rating, $review]);

    header("Location: nutzer_profil.php?id=" . $user_id);
    exit;
}
