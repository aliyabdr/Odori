<?php
session_start();
include 'db.php'; // Verbindet zur Datenbank

// Holen Sie sich die Anzeige-ID aus der URL
$ad_id = $_GET['id'] ?? 0;

// SQL-Query, um die Details der Anzeige abzurufen
$sql = "SELECT * FROM ads WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$ad_id]);
$ad = $stmt->fetch();

// Überprüfen, ob die Anzeige existiert
if (!$ad) {
    echo "Anzeige nicht gefunden!";
    exit;
}

// Holen Sie sich die Informationen des Benutzers, der die Anzeige erstellt hat
$user_sql = "SELECT * FROM users WHERE id = ?";
$user_stmt = $pdo->prepare($user_sql);
$user_stmt->execute([$ad['user_id']]);
$user = $user_stmt->fetch();
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($ad['title']); ?></title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="ad-details-container">
        <h2><?php echo htmlspecialchars($ad['title']); ?></h2>
        <div class="ad-images">
            <?php $images = explode(",", $ad['image_url']); ?>
            <?php foreach ($images as $image): ?>
                <img src="<?php echo htmlspecialchars($image); ?>" alt="Bild">
            <?php endforeach; ?>
        </div>
        <p><strong>Preis:</strong> <?php echo htmlspecialchars($ad['price']); ?>€</p>
        <p><strong>Beschreibung:</strong> <?php echo htmlspecialchars($ad['description']); ?></p>
        <p><strong>Marke:</strong> <?php echo htmlspecialchars($ad['brand']); ?></p>
        <p><strong>Farbe:</strong> <?php echo htmlspecialchars($ad['color']); ?></p>
        <p><strong>Zustand:</strong> <?php echo htmlspecialchars($ad['condition']); ?></p>
        <p><strong>Standort:</strong> <?php echo htmlspecialchars($ad['location']); ?></p>
        <h3>Verkäuferinformationen</h3>
        <p><strong>Verkäufer:</strong> <a href="nutzer_profil.php?id=<?php echo $user['id']; ?>"><?php echo htmlspecialchars($user['benutzername']); ?></a></p>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>
