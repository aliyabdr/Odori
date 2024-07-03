<?php
session_start();
include 'db_connect.php'; // Verbindet zur Datenbank

// Holen Sie sich die Benutzer-ID aus der URL
$user_id = $_GET['id'] ?? 0;

try {
    // SQL-Query, um die Details des Benutzers abzurufen
    $sql = "SELECT * FROM users WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Überprüfen, ob der Benutzer existiert
    if (!$user) {
        echo "Benutzer nicht gefunden!";
        exit;
    }

    // SQL-Query, um die Anzeigen des Benutzers abzurufen
    $ads_sql = "SELECT * FROM ads WHERE user_id = :user_id";
    $ads_stmt = $pdo->prepare($ads_sql);
    $ads_stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $ads_stmt->execute();
    $ads = $ads_stmt->fetchAll(PDO::FETCH_ASSOC);

    // SQL-Query, um die Rezensionen des Benutzers abzurufen
    $reviews_sql = "SELECT * FROM reviews WHERE user_id = :user_id";
    $reviews_stmt = $pdo->prepare($reviews_sql);
    $reviews_stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $reviews_stmt->execute();
    $reviews = $reviews_stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit;
}

$pdo = null; // Verbindung schließen
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
        <h2><?php echo htmlspecialchars($user['benutzername']); ?>'s Profil</h2>
        <img src="<?php echo htmlspecialchars($user['profilbild']); ?>" alt="Profilbild" class="profile-image">
        <p><strong>Über mich:</strong> <?php echo htmlspecialchars($user['ueber_mich']); ?></p>
        <p><strong>Standort:</strong> <?php echo htmlspecialchars($user['standort']); ?></p>

        <h3>Anzeigen</h3>
        <div class="ads-list">
            <?php foreach ($ads as $ad): ?>
                <div class="ad-item">
                    <?php $images = explode(",", $ad['image_url']); ?>
                    <?php if (count($images) > 0): ?>
                        <img src="<?php echo htmlspecialchars($images[0]); ?>" alt="Bild">
                    <?php endif; ?>
                    <h3><?php echo htmlspecialchars($ad['title']); ?></h3>
                    <p><?php echo htmlspecialchars($ad['description']); ?></p>
                    <p>Preis: <?php echo htmlspecialchars($ad['price']); ?>€</p>
                    <a href="nutzer_anzeige.php?id=<?php echo $ad['id']; ?>">Details</a>
                </div>
            <?php endforeach; ?>
        </div>

        <h3>Rezensionen</h3>
        <div class="reviews-list">
            <?php foreach ($reviews as $review): ?>
                <div class="review-item">
                    <p><strong>Bewertung:</strong> <?php echo htmlspecialchars($review['rating']); ?>/5</p>
                    <p><?php echo htmlspecialchars($review['review']); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>
