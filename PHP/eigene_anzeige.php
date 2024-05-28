<?php
include '../db_connect.php';

// ID der Anzeige
$ad_id = 0;

// Anzeige aus der Datenbank abrufen
$sql = "SELECT * FROM ads WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $ad_id);
$stmt->execute();
$result = $stmt->get_result();
$ad = $result->fetch_assoc();

// Überprüfen, ob die Anzeige existiert
if (!$ad) {
    die("Anzeige nicht gefunden.");
}

// Bilder aus JSON-Daten extrahieren
$images = json_decode($ad['bilder'], true);
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meine Anzeige</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 900px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: left;
            color: #333;
        }
        .ad-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .ad-images {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }
        .ad-images img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .ad-details {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .ad-details p {
            margin: 0;
        }
        .ad-actions {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-top: 20px;
        }
        .ad-actions button, .ad-actions a {
            padding: 10px 20px;
            background-color: #a3b18a;
            color: white;
            border: none;
            border-radius: 5px;
            text-align: center;
            text-decoration: none;
            cursor: pointer;
        }
        .ad-actions button:hover, .ad-actions a:hover {
            background-color: #8a9b68;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Meine Anzeige</h1>
        <div class="ad-header">
            <div>
                <h2><?php echo htmlspecialchars($ad['titel']); ?></h2>
                <p>Preis: <?php echo number_format($ad['preis'], 2, ',', '.'); ?>€</p>
                <p>Preistyp: <?php echo htmlspecialchars($ad['preistyp']); ?></p>
                <p>Kategorie: <?php echo htmlspecialchars($ad['kategorie']); ?></p>
            </div>
            <div>
                <p>Status: <span><?php echo ($ad['status'] == 1) ? 'Aktiv' : 'Inaktiv'; ?></span></p>
                <button>Anzeige bearbeiten</button>
                <button>Anzeige löschen</button>
            </div>
        </div>
        <div class="ad-images">
            <?php foreach ($images as $image): ?>
                <img src="<?php echo htmlspecialchars($image); ?>" alt="Bild">
            <?php endforeach; ?>
        </div>
        <div class="ad-details">
            <h3>Beschreibung</h3>
            <p><?php echo nl2br(htmlspecialchars($ad['beschreibung'])); ?></p>
        </div>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>
<?php
$stmt->close();
$conn->close();
?>
