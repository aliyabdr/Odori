<?php
include '../db_connect.php';

// ID der Anzeige
$ad_id = 1; // Die ID der Anzeige, die dargestellt werden soll

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
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
            background-color:#a3b18a ;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1, h2, h3, p {
            color: white; /* Ensure headings and paragraphs are in white */
        }
        .ad-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .ad-header h2 {
            margin: 0;
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
            background-color: white;
            color: #a3b18a;
            border: none;
            border-radius: 5px;
            text-align: center;
            text-decoration: none;
            cursor: pointer;
        }
        .ad-actions button:hover, .ad-actions a:hover {
            background-color: #8a9b68;
        }
        .ad-info {
            display: flex;
            gap: 20px;
        }
        .ad-info .ad-image {
            flex: 1;
            max-width: 300px;
        }
        .ad-info .ad-description {
            flex: 2;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .toggle-button {
            display: inline-flex;
            align-items: center;
            cursor: pointer;
            background-color: #ccc;
            border-radius: 12px;
            width: 50px;
            height: 25px;
            position: relative;
        }
        .toggle-button input {
            display: none;
        }
        .toggle-button .slider {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            border-radius: 12px;
            transition: .4s;
        }
        .toggle-button .slider:before {
            position: absolute;
            content: "";
            height: 19px;
            width: 19px;
            border-radius: 50%;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: .4s;
        }
        .toggle-button input:checked + .slider {
            background-color: #66bb6a;
        }
        .toggle-button input:checked + .slider:before {
            transform: translateX(24px);
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="container">
        <h1>Meine Anzeige</h1>
        <div class="ad-info">
            <div class="ad-image">
                <img src="<?php echo htmlspecialchars($images[0]); ?>" alt="Bild" style="width: 300px; height: auto;">
                <div class="ad-images">
                    <?php foreach ($images as $image): ?>
                        <img src="<?php echo htmlspecialchars($image); ?>" alt="Bild">
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="ad-description">
                <h2><?php echo htmlspecialchars($ad['titel']); ?></h2>
                <p><strong>Preis:</strong> <?php echo number_format($ad['preis'], 2, ',', '.'); ?>€</p>
                <p><strong>Preistyp:</strong> <?php echo htmlspecialchars($ad['preistyp']); ?></p>
                <h3>Beschreibung</h3>
                <p><?php echo nl2br(htmlspecialchars($ad['beschreibung'])); ?></p>
                <div class="ad-actions">
                    <form action="anzeige_bearbeiten.php" method="get">
                        <input type="hidden" name="id" value="<?php echo $ad_id; ?>">
                        <button type="submit">Anzeige bearbeiten</button>
                    </form>
                    <form action="pop-up_anzeige_loeschen.php" method="get">
                        <input type="hidden" name="id" value="<?php echo $ad_id; ?>">
                        <button type="submit">Anzeige löschen</button>
                    </form>
                </div>
                <div class="ad-status">
                    <label class="toggle-button">
                        <input type="checkbox" <?php if ($ad['status'] == 1) echo 'checked'; ?>>
                        <span class="slider"></span>
                    </label>
                    <span>Anzeige aktiv</span>
                </div>
            </div>
        </div>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>
<?php
$stmt->close();
$conn->close();
?>
