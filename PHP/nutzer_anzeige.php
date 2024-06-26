<?php
session_start();
include 'db.php'; // Verbindet zur Datenbank

$ad_id = $_GET['id'] ?? 0;

// Anzeige-Daten abrufen
$sql = "SELECT ads.*, users.username AS user_name, users.location AS user_location, users.profile_picture AS user_profile_picture, users.id AS user_id
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

// Bilder-Daten abrufen
$sql_images = "SELECT image_url FROM ad_images WHERE ad_id = ?";
$stmt_images = $pdo->prepare($sql_images);
$stmt_images->execute([$ad_id]);
$images = $stmt_images->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($ad['title']); ?></title>
    <style>
        /* CSS bleibt unverändert */
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
            color: #333;
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
            color: black;
        }
        .ad-header .price {
            font-size: 1.5em;
            font-weight: bold;
            color: black;
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
            color: black;
        }
        .ad-body .details .price {
            font-size: 1.5em;
            font-weight: bold;
            color: black;
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
            color: black;
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
            color: #333;
        }
        .description {
            color: black;
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
            text-align: center;
        }
        .seller-info img {
            border-radius: 50%;
            width: 50px;
            height: 50px;
            margin-bottom: 10px;
        }
        .seller-info h3 {
            margin: 0;
            font-size: 1.2em;
            color: #333;
        }
        .seller-info p {
            margin: 5px 0;
            font-size: 0.9em;
            color: #666;
        }
        .seller-info .contact-btn {
            background-color: #A3B18A;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin: 10px 0;
            display: block;
            width: 100%;
        }
        .seller-info .contact-btn:hover {
            background-color: #8F9D70;
        }
        .seller-info .profile-btn {
            background-color: transparent;
            color: #A3B18A;
            padding: 10px 20px;
            border: 1px solid #A3B18A;
            border-radius: 5px;
            cursor: pointer;
            margin: 10px 0;
            display: block;
            width: 100%;
        }
        .seller-info .profile-btn:hover {
            background-color: #A3B18A;
            color: white;
        }
        .seller-info .save-btn {
            color: #e74c3c;
            cursor: pointer;
            margin-top: 10px;
            font-size: 1.2em;
        }
        .seller-info .save-btn i {
            border: 1px solid #e74c3c;
            border-radius: 50%;
            padding: 5px;
            background-color: white;
        }
        .seller-info .save-btn i.filled {
            background-color: #e74c3c;
            color: white;
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="container">
        <div class="ad-body">
            <div class="images">
                <?php if (count($images) > 0): ?>
                    <img id="mainImage" src="<?php echo htmlspecialchars($images[0]['image_url']); ?>" alt="Bild">
                    <div class="thumbnail">
                        <?php foreach ($images as $image): ?>
                            <img src="<?php echo htmlspecialchars($image['image_url']); ?>" alt="Bild" onclick="document.getElementById('mainImage').src='<?php echo htmlspecialchars($image['image_url']); ?>'">
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
                <img src="<?php echo htmlspecialchars($ad['user_profile_picture']); ?>" alt="Profilbild">
                <h3><?php echo htmlspecialchars($ad['user_name']); ?></h3>
                <p><?php echo htmlspecialchars($ad['user_location']); ?></p>
                <button class="contact-btn">Nachricht schicken</button>
                <button class="profile-btn" onclick="window.location.href='nutzer_profil.php?user_id=<?php echo $ad['user_id']; ?>'">Profil des Verkäufers</button>
                <form action="save_ad.php" method="post">
                    <input type="hidden" name="ad_id" value="<?php echo $ad['id']; ?>">
                    <button type="submit" class="save-btn"><i class="fas fa-heart"></i> Speichern</button>
                </form>
            </div>
        </div>
    </div>
    <?php include 'footer.php'; ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>
</body>
</html>

