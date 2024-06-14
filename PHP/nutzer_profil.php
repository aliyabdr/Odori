<?php
session_start();
include 'db.php'; // Verbindet zur Datenbank

$user_id = $_GET['id'] ?? 0;
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

$reviews_stmt = $pdo->prepare("SELECT reviews.*, reviewer.benutzername AS reviewer_name FROM reviews JOIN users AS reviewer ON reviews.reviewer_id = reviewer.id WHERE reviews.user_id = ?");
$reviews_stmt->execute([$user_id]);
$reviews = $reviews_stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($user['benutzername']); ?>'s Profil</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="profile-container">
        <h1><?php echo htmlspecialchars($user['benutzername']); ?>'s Profil</h1>
        <p><?php echo htmlspecialchars($user['ueber_mich']); ?></p>
        <h2>Bewertungen</h2>
        <div class="reviews">
            <?php foreach ($reviews as $review): ?>
                <div class="review">
                    <p>Bewertung von <?php echo htmlspecialchars($review['reviewer_name']); ?>: <?php echo htmlspecialchars($review['review']); ?></p>
                    <p>Bewertung: <?php echo htmlspecialchars($review['rating']); ?> Sterne</p>
                </div>
            <?php endforeach; ?>
        </div>
        <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] != $user_id): ?>
            <h2>Rezension schreiben</h2>
            <form action="submit_nutzer_review.php" method="POST">
                <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                <label for="rating">Bewertung:</label>
                <select name="rating" id="rating">
                    <option value="1">1 Stern</option>
                    <option value="2">2 Sterne</option>
                    <option value="3">3 Sterne</option>
                    <option value="4">4 Sterne</option>
                    <option value="5">5 Sterne</option>
                </select>
                <label for="review">Rezension:</label>
                <textarea name="review" id="review" required></textarea>
                <button type="submit">Abschicken</button>
            </form>
        <?php else: ?>
            <p><a href="login.php">Loggen Sie sich ein</a>, um eine Rezension zu schreiben.</p>
        <?php endif; ?>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>
