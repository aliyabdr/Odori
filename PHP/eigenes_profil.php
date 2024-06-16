<?php
session_start();
include '../db_connect.php'; // Verbindung zur Datenbank herstellen

// Überprüfen, ob der Benutzer eingeloggt ist
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Weiterleitung zur Login-Seite, falls nicht eingeloggt
    exit;
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT username, profile_picture, about_me, location FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

$sql_ads = "SELECT * FROM ads WHERE user_id = ?";
$stmt_ads = $conn->prepare($sql_ads);
$stmt_ads->bind_param("i", $user_id);
$stmt_ads->execute();
$result_ads = $stmt_ads->get_result();
$ads = $result_ads->fetch_all(MYSQLI_ASSOC);
$stmt_ads->close();

$conn->close();
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
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
            max-width: 1000px;
            margin: 20px auto;
            margin-bottom: 100px;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
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
            background-color: #a3b18a;
            color: white;
            font-size: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 20px;
            cursor: pointer;
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
    </style>
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="container">
        <h1>Mein Profil</h1>
        <div class="profile-header">
            <div class="profile-picture" id="profilePicture">
                <?php if (!empty($user['profile_picture'])): ?>
                    <img src="<?php echo $user['profile_picture']; ?>" alt="Profilbild" style="width: 100%; height: 100%; border-radius: 50%;">
                <?php else: ?>
                    <?php echo strtoupper($user['username'][0]); ?>
                <?php endif; ?>
            </div>
            <div class="profile-info">
                <h2><?php echo htmlspecialchars($user['username']); ?></h2>
                <?php if (!empty($user['about_me'])): ?>
                    <p><?php echo htmlspecialchars($user['about_me']); ?></p>
                <?php endif; ?>
                <p><?php echo htmlspecialchars($user['location']); ?></p>
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
                            <?php if (!empty($ad['image'])): ?>
                                <img src="<?php echo htmlspecialchars($ad['image']); ?>" alt="Anzeige Bild">
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
        <div class="tab-content" id="reviews">
            <div class="no-ads">
                <p>Noch keine Bewertungen.</p>
            </div>
        </div>
        <div class="tab-content" id="saved">
            <div class="no-ads">
                <p>Noch keine gespeicherten Anzeigen.</p>
            </div>
        </div>
    </div>
    <div id="profileModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <?php if (!empty($user['profile_picture'])): ?>
                <img src="<?php echo $user['profile_picture']; ?>" alt="Profilbild">
            <?php else: ?>
                <div style="font-size: 100px; color: #a3b18a;"><?php echo strtoupper($user['username'][0]); ?></div>
            <?php endif; ?>
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

        // Modal-Funktionalität
        var modal = document.getElementById("profileModal");
        var profilePicture = document.getElementById("profilePicture");
        var span = document.getElementsByClassName("close")[0];

        profilePicture.onclick = function() {
            modal.style.display = "block";
        }

        span.onclick = function() {
            modal.style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
</body>
</html>
