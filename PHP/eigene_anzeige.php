<?php
session_start();
include 'db.php'; // Verbindet zur Datenbank

$ad_id = $_GET['id'] ?? 0;
$user_id = $_SESSION['user_id'] ?? 0;

try {
    // Anzeige-Daten abrufen und Berechtigung überprüfen
    $sql = "SELECT ads.*, users.username AS user_name, users.location AS user_location, users.profile_picture AS user_profile_picture, users.id AS user_id
            FROM ads
            JOIN users ON ads.user_id = users.id
            WHERE ads.id = :ad_id AND ads.user_id = :user_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':ad_id', $ad_id, PDO::PARAM_INT);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $ad = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$ad) {
        echo "Anzeige nicht gefunden oder Sie haben keine Berechtigung, diese Anzeige zu bearbeiten.";
        exit;
    }

    // Bilder-Daten abrufen
    $sql_images = "SELECT image_url FROM ads WHERE id = :id";
    $stmt_images = $pdo->prepare($sql_images);
    $stmt_images->bindParam(':id', $ad_id, PDO::PARAM_INT);
    $stmt_images->execute();
    $images = $stmt_images->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
    exit;
}

$pdo = null; // Verbindung schließen
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($ad['title'], ENT_QUOTES, 'UTF-8'); ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 1000px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            display: flex;
            flex-wrap: wrap;
            color: black;
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
            max-width: 100%;
            margin: 0 auto;
        }
        .ad-body .images img {
            width: 100%;
            border-radius: 8px;
            margin-bottom: 10px;
        }
        .ad-body .details {
            flex: 2;
            display: flex;
            flex-direction: column;
            max-width: 100%;
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
            margin-top: 5px;
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
        .actions-container {
            flex: 1;
            max-width: 100%;
            margin: 20px 0;
            display: flex;
            flex-direction: column;
            gap: 10px;
            align-items: center;
        }
        .actions-container .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #A3B18A;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
            margin-top: 10px;
            width: 100%;
            max-width: 200px;
        }
        .actions-container .btn:hover {
            background-color: #8F9D70;
        }
        /* Modal-Stile */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            padding: 20px;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.5);
        }
        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 600px;
            text-align: center;
            border-radius: 20px;
            color: black;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
        .modal-buttons {
            margin-top: 20px;
        }
        .modal-buttons button {
            padding: 10px 20px;
            margin: 0 10px;
            background-color: #A3B18A;
            color: white;
            border: none;
            border-radius: 20px;
            cursor: pointer;
        }
        .modal-buttons button:hover {
            background-color: #8a9b68;
        }
        @media (max-width: 1000px) {
            .container {
                width: 90%;
                margin: 20px auto;
                padding: 10px;
                flex-direction: column;
            }
            .ad-header h1, .ad-body .details h1 {
                font-size: 1.5em;
            }
            .ad-header .price, .ad-body .details .price {
                font-size: 1.2em;
            }
        }
        @media (max-width: 600px) {
            .container {
                width: 100%;
                margin: 10px auto;
                padding: 5px;
                flex-direction: column;
            }
            .ad-header {
                flex-direction: column;
                align-items: flex-start;
            }
            .ad-body {
                flex-direction: column;
                align-items: flex-start;
            }
            .ad-body .details, .ad-body .images {
                max-width: 100%;
                width: 100%;
            }
            .actions-container {
                flex-direction: column;
                align-items: stretch;
                margin: 10px 0;
            }
            .actions-container .btn {
                width: 100%;
                max-width: none;
            }
            .modal-content {
                width: 95%;
            }
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="container">
        <div class="ad-body">
            <div class="images">
                 <?php if (!empty($ad['image_url'])): ?>
                    <img src="<?php echo htmlspecialchars($ad['image_url'], ENT_QUOTES, 'UTF-8'); ?>" alt="Anzeige Bild">
                    <?php endif; ?>
            </div>
            <div class="details">
                <h1><?php echo htmlspecialchars($ad['title'], ENT_QUOTES, 'UTF-8'); ?></h1>
                <div class="price">
                    <?php echo htmlspecialchars($ad['price'], ENT_QUOTES, 'UTF-8'); ?>€
                    <?php if (!empty($ad['old_price'])): ?>
                        <span class="old-price"><?php echo htmlspecialchars($ad['old_price'], ENT_QUOTES, 'UTF-8'); ?>€</span>
                    <?php endif; ?>
                </div>
                <div class="ad-details">
                    <table>
                        <tr>
                            <th>Marke:</th>
                            <td><?php echo htmlspecialchars($ad['brand'], ENT_QUOTES, 'UTF-8'); ?></td>
                        </tr>
                        <tr>
                            <th>Farbe:</th>
                            <td><?php echo htmlspecialchars($ad['color'], ENT_QUOTES, 'UTF-8'); ?></td>
                        </tr>
                        <tr>
                            <th>Zustand:</th>
                            <td><?php echo htmlspecialchars($ad['condition'], ENT_QUOTES, 'UTF-8'); ?></td>
                        </tr>
                        <tr>
                            <th>Kategorie:</th>
                            <td><?php echo htmlspecialchars($ad['category'], ENT_QUOTES, 'UTF-8'); ?></td>
                        </tr>
                        <tr>
                            <th>Hochgeladen:</th>
                            <td><?php echo htmlspecialchars($ad['created_at'], ENT_QUOTES, 'UTF-8'); ?></td>
                        </tr>
                    </table>
                </div>
                <div class="description">
                    <h3>Beschreibung</h3>
                    <p><?php echo htmlspecialchars($ad['description'], ENT_QUOTES, 'UTF-8'); ?></p>
                </div>
            </div>
        </div>
        <div class="actions-container">
            <button class="btn" id="editAd" onclick="window.location.href='anzeige_bearbeiten.php?id=<?php echo $ad_id; ?>'">Anzeige bearbeiten</button>
            <button class="btn" id="deleteAd">Anzeige löschen</button>
        </div>
    </div>
    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <p>Willst du diese Anzeige wirklich löschen?</p>
            <div class="modal-buttons">
                <button id="confirmDelete">Ja</button>
                <button onclick="closeModal()">Nein</button>
            </div>
        </div>
    </div>
    <?php include 'footer.php'; ?>
    <script>
        // Modal-Funktionalität für Löschen
        var deleteModal = document.getElementById("deleteModal");
        var deleteButton = document.getElementById('deleteAd');
        var confirmDeleteButton = document.getElementById('confirmDelete');
        var adToDelete = "<?php echo $ad_id; ?>";

        deleteButton.onclick = function() {
            deleteModal.style.display = "block";
        }

        confirmDeleteButton.onclick = function() {
            if (adToDelete) {
                window.location.href = 'delete_ad.php?id=' + adToDelete;
            }
        }

        function closeModal() {
            deleteModal.style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == deleteModal) {
                deleteModal.style.display = "none";
            }
        }
    </script>
</body>
</html>



