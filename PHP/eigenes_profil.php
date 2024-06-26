<?php
session_start();
include '../db_connect.php'; // Verbindung zur Datenbank herstellen

// Überprüfen, ob der Benutzer eingeloggt ist
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Weiterleitung zur Login-Seite, falls nicht eingeloggt
    exit;
}

$user_id = $_SESSION['user_id'];

// Erste Abfrage für Benutzerdaten
$sql = "SELECT username, profile_picture, location, saved_ads FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

// Überprüfen, ob die 'location'-Spalte existiert und nicht leer ist
$user_location = !empty($user['location']) ? $user['location'] : '';

// Zweite Abfrage für Anzeigen
$sql_ads = "SELECT * FROM ads WHERE user_id = ?";
$stmt_ads = $conn->prepare($sql_ads);
$stmt_ads->bind_param("i", $user_id);
$stmt_ads->execute();
$result_ads = $stmt_ads->get_result();
$ads = $result_ads->fetch_all(MYSQLI_ASSOC);
$stmt_ads->close();

// Gespeicherte Anzeigen abrufen
$saved_ads = !empty($user['saved_ads']) ? explode(',', $user['saved_ads']) : [];
$saved_ads_list = [];
if (!empty($saved_ads)) {
    $placeholders = implode(',', array_fill(0, count($saved_ads), '?'));
    $types = str_repeat('i', count($saved_ads));
    
    $sql_saved = "SELECT * FROM ads WHERE id IN ($placeholders)";
    $stmt_saved = $conn->prepare($sql_saved);
    $stmt_saved->bind_param($types, ...$saved_ads);
    $stmt_saved->execute();
    $result_saved = $stmt_saved->get_result();
    $saved_ads_list = $result_saved->fetch_all(MYSQLI_ASSOC);
    $stmt_saved->close();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mein Profil</title>
    <link rel="stylesheet" href="../style.css">
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
            position: relative;
            color: black;
        }
        .edit-icon {
            position: absolute;
            top: 20px;
            right: 20px;
            width: 30px;
            height: 30px;
            cursor: pointer;
        }
        .profile-header {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }
        .profile-picture {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            overflow: hidden;
            background-color: #a3b18a;
            color: white;
            font-size: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 20px;
            cursor: pointer;
        }
        .profile-picture img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .profile-info h2 {
            margin: 0;
            font-size: 36px;
        }
        .profile-info p {
            margin: 5px 0;
            font-size: 18px;
            color: #555;
        }
        .ads-section {
            margin-top: 20px;
        }
        .ads-section h3 {
            border-bottom: 2px solid #a3b18a;
            padding-bottom: 10px;
            margin-bottom: 20px;
            font-size: 24px;
        }
        .ad {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 10px;
            position: relative;
            display: flex;
            align-items: center;
            text-decoration: none;
            color: black;
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
        .ad-details .label {
            font-weight: bold;
        }
        .ad-actions {
            position: absolute;
            top: 10px;
            right: 10px;
            display: flex;
            gap: 10px;
        }
        .ad-actions img {
            width: 20px;
            height: 20px;
            cursor: pointer;
        }
        .no-ads {
            text-align: center;
            margin-top: 20px;
            font-size: 18px;
        }
        .tabs {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
            border-bottom: 1px solid #ddd;
        }
        .tabs div {
            padding: 10px 20px;
            cursor: pointer;
            border-bottom: 2px solid transparent;
        }
        .tabs div.active {
            border-bottom: 2px solid #a3b18a;
        }
        .tab-content {
            display: none;
        }
        .tab-content.active {
            display: block;
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
            margin: 15% auto;
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
        .modal img {
            width: 100%;
            height: auto;
            border-radius: 10px;
        }
        .modal-buttons {
            margin-top: 20px;
        }
        .modal-buttons button {
            padding: 10px 20px;
            margin: 0 10px;
            background-color: #a3b18a;
            color: white;
            border: none;
            border-radius: 20px;
            cursor: pointer;
        }
        .modal-buttons button:hover {
            background-color: #8a9b68;
        }
        .ad:hover {
            background-color: #f0f0f0;
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="container">
        <h1>Mein Profil</h1>
        <img src="../img/icon_pencil.jpg" alt="Bearbeiten" class="edit-icon" id="editProfile">
        <div class="profile-header">
            <div class="profile-picture" id="profilePicture">
                <?php if (!empty($user['profile_picture'])): ?>
                    <img src="<?php echo htmlspecialchars($user['profile_picture']); ?>" alt="Profilbild">
                <?php else: ?>
                    <?php echo strtoupper(htmlspecialchars($user['username'][0])); ?>
                <?php endif; ?>
            </div>
            <div class="profile-info">
                <h2><?php echo htmlspecialchars($user['username']); ?></h2>
                <p><?php echo htmlspecialchars($user_location); ?></p>
            </div>
        </div>
        <div class="tabs">
            <div class="tab active" data-tab="ads">Meine Anzeigen</div>
            <div class="tab" data-tab="reviews">Meine Bewertungen</div>
            <div class="tab" data-tab="saved">Meine gespeicherten Anzeigen</div>
        </div>
        <div class="tab-content active" id="ads">
            <div class="ads-section">
                <?php if (empty($ads)): ?>
                    <div class="no-ads">
                        <p>Noch keine Anzeigen. <a href="anzeige_erstellen.php">Jetzt eine erstellen</a></p>
                    </div>
                <?php else: ?>
                    <?php foreach ($ads as $ad): ?>
                        <div class="ad">
                            <?php if (!empty($ad['image_url'])): ?>
                                <img src="<?php echo htmlspecialchars($ad['image_url']); ?>" alt="Anzeige Bild">
                            <?php endif; ?>
                            <div class="ad-details">
                                <h4><?php echo htmlspecialchars($ad['title']); ?></h4>
                                <p><span class="label">Preis:</span> <?php echo htmlspecialchars($ad['price']); ?> €</p>
                                <p><span class="label">Kategorie:</span> <?php echo htmlspecialchars($ad['category']); ?></p>
                                <p><?php echo htmlspecialchars($ad['description']); ?></p>
                            </div>
                            <div class="ad-actions">
                                <a href="anzeige_bearbeiten.php?id=<?php echo $ad['id']; ?>"><img src="../img/icon_pencil.jpg" alt="Bearbeiten"></a>
                                <img src="../img/icon_delete.jpg" alt="Löschen" class="delete-ad" data-id="<?php echo $ad['id']; ?>">
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
        <div class="tab-content" id="reviews">
            <div class="no-ads">
                <p>Noch keine Bewertungen.</p>
            </div>
        </div>
        <div class="tab-content" id="saved">
            <div class="ads-section">
                <?php if (empty($saved_ads_list)): ?>
                    <div class="no-ads">
                        <p>Noch keine gespeicherten Anzeigen.</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($saved_ads_list as $ad): ?>
                        <a href="nutzer_anzeige.php?id=<?php echo $ad['id']; ?>" class="ad">
                            <?php if (!empty($ad['image_url'])): ?>
                                <img src="<?php echo htmlspecialchars($ad['image_url']); ?>" alt="Anzeige Bild">
                            <?php endif; ?>
                            <div class="ad-details">
                                <h4><?php echo htmlspecialchars($ad['title']); ?></h4>
                                <p><span class="label">Preis:</span> <?php echo htmlspecialchars($ad['price']); ?> €</p>
                                <p><span class="label">Kategorie:</span> <?php echo htmlspecialchars($ad['category']); ?></p>
                                <p><?php echo htmlspecialchars($ad['description']); ?></p>
                            </div>
                        </a>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div id="profileModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <?php if (!empty($user['profile_picture'])): ?>
                <img src="<?php echo htmlspecialchars($user['profile_picture']); ?>" alt="Profilbild">
            <?php else: ?>
                <div style="font-size: 100px; color: #a3b18a;"><?php echo strtoupper(htmlspecialchars($user['username'][0])); ?></div>
            <?php endif; ?>
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
        // Tab-Switcher
        document.querySelectorAll('.tab').forEach(tab => {
            tab.addEventListener('click', () => {
                document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
                tab.classList.add('active');
                
                document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));
                document.getElementById(tab.getAttribute('data-tab')).classList.add('active');
            });
        });

        // Modal-Funktionalität für Profilbild
        var profileModal = document.getElementById("profileModal");
        var profilePicture = document.getElementById("profilePicture");
        var profileClose = document.getElementsByClassName("close")[0];

        profilePicture.onclick = function() {
            profileModal.style.display = "block";
        }

        profileClose.onclick = function() {
            profileModal.style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == profileModal) {
                profileModal.style.display = "none";
            }
        }

        // Modal-Funktionalität für Löschen
        var deleteModal = document.getElementById("deleteModal");
        var deleteButtons = document.querySelectorAll('.delete-ad');
        var confirmDeleteButton = document.getElementById('confirmDelete');
        var adToDelete;

        deleteButtons.forEach(button => {
            button.addEventListener('click', () => {
                adToDelete = button.getAttribute('data-id');
                deleteModal.style.display = "block";
            });
        });

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

        // Weiterleitung zur Bearbeitungsseite
        document.getElementById('editProfile').onclick = function() {
            window.location.href = 'eigenes_profil_bearbeiten.php';
        }
    </script>
</body>
</html>




























