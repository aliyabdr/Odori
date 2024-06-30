<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start(); // Startet die Session nur, wenn noch keine aktive Session vorhanden ist
}

include 'db.php'; // Verbindet zur Datenbank

// Verwende die user_id aus der URL, falls vorhanden
$profile_user_id = $_GET['user_id'] ?? 0;

// Benutzerinformationen des angezeigten Profils abrufen
$stmt = $pdo->prepare("SELECT username, profile_picture, location FROM users WHERE id = ?");
$stmt->execute([$profile_user_id]);
$profile_user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$profile_user) {
    echo "Benutzer nicht gefunden.";
    exit;
}

// Anzeigen des Nutzers abrufen
$sql_ads = "SELECT * FROM ads WHERE user_id = ?";
$stmt_ads = $pdo->prepare($sql_ads);
$stmt_ads->execute([$profile_user_id]);
$ads = $stmt_ads->fetchAll(PDO::FETCH_ASSOC);

// Überprüfen, ob die 'location'-Spalte existiert und nicht leer ist
$profile_user_location = !empty($profile_user['location']) ? $profile_user['location'] : '';

// Bewertungen des Nutzers abrufen
$reviews_stmt = $pdo->prepare("SELECT reviews.*, reviewer.username AS reviewer_name FROM reviews JOIN users AS reviewer ON reviews.reviewer_id = reviewer.id WHERE reviews.user_id = ?");
$reviews_stmt->execute([$profile_user_id]);
$reviews = $reviews_stmt->fetchAll(PDO::FETCH_ASSOC);

// Überprüfung, ob der Benutzer eingeloggt ist und Benutzerdaten abrufen
if (isset($_SESSION['user_id'])) {
    $current_user_id = $_SESSION['user_id'];
    $sql = "SELECT username, profile_picture FROM users WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$current_user_id]);
    $current_user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($current_user) {
        $_SESSION['username'] = $current_user['username'];
        $_SESSION['user_profile_picture'] = $current_user['profile_picture'];
    }
}
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($profile_user['username']); ?>'s Profil</title>
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
        .ads-section, .reviews-section {
            margin-top: 20px;
        }
        .ads-section h3, .reviews-section h3 {
            border-bottom: 2px solid #a3b18a;
            padding-bottom: 10px;
            margin-bottom: 20px;
            font-size: 24px;
        }
        .ad, .review {
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
        .ad-details, .review-details {
            flex: 1;
        }
        .ad-details h4, .review-details h4 {
            margin: 0;
            font-size: 20px;
        }
        .ad-details p, .review-details p {
            margin: 5px 0;
            font-size: 16px;
            color: #777;
        }
        .ad-details .label, .review-details .label {
            font-weight: bold;
        }
        .no-content {
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
        .review-form {
            margin-top: 20px;
        }
        .review-form h3 {
            margin-bottom: 10px;
        }
        .review-form label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .review-form select, .review-form textarea {
            width: 100%;
            margin-bottom: 10px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .review-form button {
            padding: 10px 20px;
            background-color: #a3b18a;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .review-form button:hover {
            background-color: #8a9b68;
        }
        .login-prompt {
            text-align: center;
            margin-top: 20px;
        }
        .login-prompt a {
            padding: 10px 20px;
            background-color: #a3b18a;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .login-prompt a:hover {
            background-color: #8a9b68;
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="container">
        <div class="profile-header">
            <div class="profile-picture">
                <?php if (!empty($profile_user['profile_picture'])): ?>
                    <img src="<?php echo htmlspecialchars($profile_user['profile_picture']); ?>" alt="Profilbild">
                <?php else: ?>
                    <?php echo strtoupper(htmlspecialchars($profile_user['username'][0])); ?>
                <?php endif; ?>
            </div>
            <div class="profile-info">
                <h2><?php echo htmlspecialchars($profile_user['username']); ?></h2>
                <p><?php echo htmlspecialchars($profile_user_location); ?></p>
            </div>
        </div>
        <div class="tabs">
            <div class="tab active" data-tab="ads">Anzeigen</div>
            <div class="tab" data-tab="reviews">Bewertungen</div>
        </div>
        <div class="tab-content active" id="ads">
            <div class="ads-section">
                <?php if (empty($ads)): ?>
                    <div class="no-content">
                        <p>Noch keine Anzeigen.</p>
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
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
        <div class="tab-content" id="reviews">
            <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] != $profile_user_id): ?>
                <div class="review-form">
                    <h3>Rezension schreiben</h3>
                    <form action="submit_review.php" method="POST">
                        <input type="hidden" name="user_id" value="<?php echo $profile_user_id; ?>">
                        <label for="rating">Bewertung:</label>
                        <select name="rating" id="rating" required>
                            <option value="1">1 Stern</option>
                            <option value="2">2 Sterne</option>
                            <option value="3">3 Sterne</option>
                            <option value="4">4 Sterne</option>
                            <option value="5">5 Sterne</option>
                        </select>
                        <label for="review">Rezension:</label>
                        <textarea name="review" id="review" required></textarea>
                        <button type="submit">Abschicken</button>
                    </form>
                </div>
            <?php else: ?>
                <div class="login-prompt">
                    <p>Loggen Sie sich ein, um eine Rezension zu schreiben.</p>
                    <a href="login.php">Login</a>
                </div>
            <?php endif; ?>
            <div class="reviews-section">
                <?php if (empty($reviews)): ?>
                    <div class="no-content">
                        <p>Noch keine Bewertungen.</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($reviews as $review): ?>
                        <div class="review">
                            <div class="review-details">
                                <h4>Bewertung von <?php echo htmlspecialchars($review['reviewer_name']); ?></h4>
                                <p><?php echo htmlspecialchars($review['review']); ?></p>
                                <p><span class="label">Bewertung:</span> <?php echo htmlspecialchars($review['rating']); ?> Sterne</p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
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
    </script>
</body>
</html>
