<?php
session_start();
include 'db.php'; // Verbindet zur Datenbank

$ad_id = $_GET['id'] ?? 0;

$sql = "SELECT ads.*, users.username AS user_name, users.location AS user_location
        FROM ads
        JOIN users ON ads.user_id = users.id
        WHERE ads.id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$ad_id]);
$ad = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$ad) {
    echo "Anzeige nicht gefunden.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($ad['title']); ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
            color: #333; /* Dunkelgraue Schriftfarbe für den gesamten Text */
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            display: flex;
            flex-wrap: wrap;
        }
        .ad-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            width: 100%;
        }
        .ad-header h1 {
            font-size: 2em;
            font-weight: bold;
            margin: 0;
            color: black; /* Schwarze Schriftfarbe für den Titel */
        }
        .ad-header .price {
            font-size: 1.5em;
            font-weight: bold;
            color: black; /* Schwarze Schriftfarbe für den Preis */
        }
        .ad-header .old-price {
            text-decoration: line-through;
            color: black;
            margin-left: 10px;
        }
        .ad-body {
            display: flex;
            flex: 2;
            flex-wrap: wrap;
            gap: 20px;
        }
        .ad-body .images {
            flex: 1;
            max-width: 300px;
        }
        .ad-body .images img {
            width: 100%;
            border-radius: 8px;
            margin-bottom: 10px;
        }
        .ad-body .images .thumbnail {
            display: flex;
            gap: 5px;
            margin-top: 10px;
        }
        .ad-body .images .thumbnail img {
            width: 50px;
            height: 50px;
            border-radius: 4px;
            cursor: pointer;
            border: 1px solid #ddd;
        }
        .ad-body .details {
            flex: 2;
            display: flex;
            flex-direction: column;
        }
        .ad-body .details h1 {
            font-size: 2em;
            font-weight: bold;
            margin: 0;
            color: black; /* Schwarze Schriftfarbe für den Titel */
        }
        .ad-body .details .price {
            font-size: 1.5em;
            font-weight: bold;
            color: black; /* Schwarze Schriftfarbe für den Preis */
            margin-bottom: 10px;
        }
        .ad-body .details .old-price {
            text-decoration: line-through;
            color: black;
            margin-left: 10px;
        }
        .ad-body .details .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #A3B18A;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
            align-self: flex-start;
        }
        .ad-body .details .btn:hover {
            background-color: #8F9D70;
        }
        .ad-details {
            margin-top: 20px;
        }
        .ad-details h3 {
            margin-bottom: 10px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
            color: black; /* Schwarze Schriftfarbe für den Titel "Beschreibung" */
        }
        .ad-details table {
            width: 100%;
            border-collapse: collapse;
        }
        .ad-details table th,
        .ad-details table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            color: #333; /* Dunkelgraue Schriftfarbe für die Tabelle */
        }
        .description {
            color: black; /* Schwarze Schriftfarbe für die Beschreibung */
        }
        .seller-info-container {
            flex: 1;
            max-width: 300px;
            margin-left: 20px;
        }
        .seller-info {
            margin-top: 20px;
            padding: 20px;
            background-color: #f1f1f1;
            border-radius: 8px;
            display: flex;
            align-items: center;
            color: #333; /* Dunkelgraue Schriftfarbe für Verkäuferinformationen */
        }
        .seller-info img {
            border-radius: 50%;
            width: 50px;
            height: 50px;
            margin-right: 20px;
        }
        .seller-info h3 {
            margin-top: 0;
        }
        .seller-info p {
            margin: 5px 0;
        }
        .seller-info .contact-btn {
            background-color: #A3B18A;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .seller-info .contact-btn:hover {
            background-color: #8F9D70;
        }
        .seller-info .save-btn {
            color: #e74c3c;
            cursor: pointer;
            margin-left: auto;
            font-size: 1.2em;
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="container">
        <div class="ad-body">
            <div class="images">
                <?php $images = explode(",", $ad['image_url']); ?>
                <?php if (count($images) > 0): ?>
                    <img id="mainImage" src="<?php echo htmlspecialchars($images[0]); ?>" alt="Bild">
                    <div class="thumbnail">
                        <?php foreach ($images as $image): ?>
                            <img src="<?php echo htmlspecialchars($image); ?>" alt="Bild" onclick="document.getElementById('mainImage').src='<?php echo htmlspecialchars($image); ?>'">
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="details">
                <h1><?php echo htmlspecialchars($ad['title']); ?></h1>
                <div class="price">
                    <?php echo htmlspecialchars($ad['price']); ?>€
                    <?php if (!empty($ad['old_price'])): ?>
                        <span class="old-price"><?php echo htmlspecialchars($ad['old_price']); ?>€</span>
                    <?php endif; ?>
                </div>
                <form action="kaufen.php" method="post">
                    <input type="hidden" name="ad_id" value="<?php echo $ad_id; ?>">
                    <button class="btn" type="submit">Kaufen</button>
                </form>
                <div class="ad-details">
                    <table>
                        <tr>
                            <th>Preis:</th>
                            <td>Verhandelbar</td>
                        </tr>
                        <tr>
                            <th>Marke:</th>
                            <td><?php echo htmlspecialchars($ad['brand']); ?></td>
                        </tr>
                        <tr>
                            <th>Farbe:</th>
                            <td><?php echo htmlspecialchars($ad['color']); ?></td>
                        </tr>
                        <tr>
                            <th>Zustand:</th>
                            <td><?php echo htmlspecialchars($ad['condition']); ?></td>
                        </tr>
                        <tr>
                            <th>Kategorie:</th>
                            <td><?php echo htmlspecialchars($ad['category']); ?></td>
                        </tr>
                        <tr>
                            <th>Hochgeladen:</th>
                            <td><?php echo htmlspecialchars($ad['created_at']); ?></td>
                        </tr>
                    </table>
                </div>
                <div class="description">
                    <h3>Beschreibung</h3>
                    <p><?php echo htmlspecialchars($ad['description']); ?></p>
                </div>
            </div>
        </div>
        <div class="seller-info-container">
            <div class="seller-info">
                <img src="path/to/profile/picture.jpg" alt="Profilbild">
                <div>
                    <h3><?php echo htmlspecialchars($ad['user_name']); ?></h3>
                    <p><?php echo htmlspecialchars($ad['user_location']); ?></p>
                    <button class="contact-btn">Nachricht schicken</button>
                </div>
                <div class="save-btn">
                    <i class="fas fa-heart"></i> Speichern
                </div>
            </div>
        </div>
    </div>
    <?php include 'footer.php'; ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>
</body>
</html>
