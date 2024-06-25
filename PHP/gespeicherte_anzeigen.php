<?php
session_start();
include '../db_connect.php'; // Verbindung zur Datenbank herstellen

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Gespeicherte Anzeigen abrufen
$sql = "SELECT saved_ads FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$saved_ads = explode(',', $user['saved_ads']);

if (empty($saved_ads[0])) {
    $saved_ads = []; // Wenn keine Anzeigen gespeichert sind, leeres Array
}

$ads = [];
if (!empty($saved_ads)) {
    $placeholders = implode(',', array_fill(0, count($saved_ads), '?'));
    $types = str_repeat('i', count($saved_ads));

    $sql_ads = "SELECT * FROM ads WHERE id IN ($placeholders)";
    $stmt_ads = $conn->prepare($sql_ads);
    $stmt_ads->bind_param($types, ...$saved_ads);
    $stmt_ads->execute();
    $result_ads = $stmt_ads->get_result();
    $ads = $result_ads->fetch_all(MYSQLI_ASSOC);
    $stmt_ads->close();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gespeicherte Anzeigen</title>
    <style>
        body {
            font-family: 'Lato', sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            color: black;
        }
        h1 {
            text-align: center;
            color: black;
        }
        .ad {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
        }
        .ad img {
            max-width: 100px;
            margin-right: 20px;
        }
        .ad-details {
            flex: 1;
        }
        .ad-details h4 {
            margin: 0;
            font-size: 20px;
        }
        .ad-details p {
            margin: 5px 0;
            font-size: 16px;
            color: #777;
        }
        .no-ads {
            text-align: center;
            margin-top: 20px;
            font-size: 18px;
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="container">
        <h1>Gespeicherte Anzeigen</h1>
        <div class="ads-section">
            <?php if (empty($ads)): ?>
                <div class="no-ads">
                    <p>Keine gespeicherten Anzeigen.</p>
                </div>
            <?php else: ?>
                <?php foreach ($ads as $ad): ?>
                    <div class="ad">
                        <?php if (!empty($ad['image_url'])): ?>
                            <img src="<?php echo htmlspecialchars($ad['image_url']); ?>" alt="Anzeige Bild">
                        <?php endif; ?>
                        <div class="ad-details">
                            <h4><?php echo htmlspecialchars($ad['title']); ?></h4>
                            <p>Preis: <?php echo htmlspecialchars($ad['price']); ?> €</p>
                            <p>Kategorie: <?php echo htmlspecialchars($ad['category']); ?></p>
                            <p><?php echo htmlspecialchars($ad['description']); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>
