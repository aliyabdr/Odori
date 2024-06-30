<?php
session_start();
include 'db.php'; // Verbindet zur Datenbank

$search = $_GET['artikel'] ?? '';
$sort = $_GET['sort'] ?? 'newest';
$filters = [
    'price_min' => $_GET['price_min'] ?? 0,
    'price_max' => $_GET['price_max'] ?? 10000,
    'color' => $_GET['color'] ?? '',
    'brand' => $_GET['brand'] ?? '',
    'condition' => $_GET['condition'] ?? ''
];

$user_id = $_SESSION['user_id'] ?? 0;

// SQL Query für Suchergebnisse
$sql = "SELECT * FROM ads WHERE user_id != ? AND title LIKE ? AND price BETWEEN ? AND ? AND color LIKE ? AND brand LIKE ? AND `condition` LIKE ?";

if ($sort == 'price_asc') {
    $sql .= " ORDER BY price ASC";
} elseif ($sort == 'price_desc') {
    $sql .= " ORDER BY price DESC";
} else {
    $sql .= " ORDER BY created_at DESC";
}

$stmt = $pdo->prepare($sql);
$stmt->execute([$user_id, "%$search%", $filters['price_min'], $filters['price_max'], "%{$filters['color']}%", "%{$filters['brand']}%", "%{$filters['condition']}%"]);
$ads = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($ads === false) {
    $ads = [];
}

// Filteroptionen aus den Daten abrufen
$colors = ["Blau", "Braun", "Gelb", "Gold", "Grün", "Rosa", "Rot", "Schwarz", "Silber", "Transparent", "Weiss", "Andere"];
$brands = ["Deuter", "Garmin", "Helinox", "La Sportiva", "Leki", "Mammut", "Nalgene", "Ortlieb", "Primus", "Vaude", "Andere"];
$conditions = ["gebraucht", "neu"];
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Suchergebnisse</title>
    <style>
        /* Importiere die Schriftart 'Lato' */
        @import url('https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap');

        /* Grundlegendes Layout und Stile */
        html, body {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: 'Lato', sans-serif; /* Anwenden der Schriftart 'Lato' */
        }

        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            color: white;
        }

        body.startseite {
            flex: 1;
            position: relative;
            background-image: url('../img/startseite.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .overlay {
            position: relative;
            flex: 1;
            background: rgba(0, 0, 0, 0.5); /* Dunkler Overlay für besseren Kontrast */
            display: flex;
            flex-direction: column; /* Ensures vertical alignment */
            justify-content: center; /* Centers content vertically */
            align-items: flex-start; /* Aligns content to the left */
            text-align: left; /* Aligns text to the left */
            padding: 50px; /* Abstand von den Rändern */
        }

        .container {
            max-width: 800px;
            padding: 20px;
            margin-top: 50px; /* Adds space above the container */
            margin-bottom: 50px; /* Adds space below the container */
        }

        h1 {
            font-size: 2.5em;
            margin-bottom: 20px;
            line-height: 1.2; /* Linienhöhe für bessere Lesbarkeit */
        }

        form {
            display: flex;
            justify-content: flex-start; /* Aligns form to the left */
            gap: 10px;
            flex-wrap: wrap; /* Zeilenumbruch bei kleineren Bildschirmen */
        }

        .search-bar {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }

        .search-bar input {
            padding: 15px; /* Mehr Padding für größere Felder */
            font-size: 1em;
            border: none;
            border-radius: 25px; /* Runde Ecken */
            width: 200px;
            margin: 0 5px; /* Mehr Rand */
        }

        .search-bar button {
            padding: 15px 25px;
            font-size: 1em;
            border: none;
            border-radius: 25px; /* Runde Ecken */
            background-color: #A3B18A; /* Anpassung der Farbe */
            color: white; /* Schriftfarbe */
            cursor: pointer;
            transition: background-color 0.3s;
            margin: 0 5px; /* Mehr Rand */
        }

        .search-bar button:hover {
            background-color: #8F9D70;
        }

        /* Styles für die Suchergebnisseite */
        .search-results-container {
            padding: 20px;
            color: black; /* Textfarbe anpassen */
        }

        .filter-bar {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 20px;
            padding: 10px;
            background-color: #f0f0f0;
            border-radius: 25px;
        }

        .filter-bar form {
            display: flex;
            flex-direction: row;
            gap: 10px;
            flex-wrap: wrap; /* Allows the filter items to wrap in smaller screens */
        }

        .filter-bar div {
            display: flex;
            flex-direction: column;
        }

        .filter-bar .input-container {
            position: relative;
            display: flex;
            align-items: center;
        }

        .filter-bar .input-container input {
            padding-right: 20px; /* Platz für das Euro-Symbol */
        }

        .filter-bar .input-container .euro-symbol {
            position: absolute;
            right: 10px;
            pointer-events: none; /* Klicks durchlassen */
        }

        .filter-bar button, .filter-bar input, .filter-bar select {
            margin-top: 5px;
            margin-bottom: 5px;
            padding: 10px;
            border: none;
            border-radius: 25px;
            background-color: white;
            cursor: pointer;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }

        .filter-bar button:hover, .filter-bar input:hover, .filter-bar select:hover {
            background-color: #e0e0e0;
        }

        .filter-bar button {
            margin-top: 23px;
            margin-bottom: 5px;
            height: 38px; /* Gleiche Breite wie die anderen Filterfelder */
            padding: 0px 20px;
            font-size: 1em;
            border: none;
            border-radius: 25px;
            background-color: #A3B18A;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .filter-bar button:hover {
            background-color: #8F9D70;
        }

        .sort-bar {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 20px;
        }

        .ads-list {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .ad-item-link {
            text-decoration: none;
            color: inherit;
            flex-basis: calc(33.333% - 20px); /* Drei Anzeigen pro Zeile */
            box-sizing: border-box;
        }

        .ad-item {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 10px;
            height: 510px;
            width: 100%; /* Breite des übergeordneten Links */
            box-sizing: border-box;
            transition: box-shadow 0.3s;
            display: flex;
            flex-direction: column;
            align-items: flex-start; /* Links ausgerichtet */
        }

        .ad-item .img-container {
            width: 100%;
            padding-top: 100%; /* 1:1 Verhältnis */
            position: relative;
            overflow: hidden;
        }

        .ad-item img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover; /* Bild wird zentriert und beschnitten, um das Verhältnis beizubehalten */
            object-position: center; /* Bild wird zentriert */
            border-bottom: 1px solid #ddd;
            margin-bottom: 20px;
        }

        .ad-item:hover {
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        .ad-item h3, .ad-item p {
            margin: 5px 0;
            text-align: left; /* Links ausgerichtet */
        }

        .ad-item h3 {
            margin-top: 15px;
            font-size: 1.5em;
            color: #333;
        }

        .ad-item p {
            font-size: 0.9em;
            color: #666;
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="search-results-container">
        <h2><?php echo count($ads); ?> Suchergebnisse für "<?php echo htmlspecialchars($search); ?>"</h2>
        <div class="filter-bar">
            <!-- Filter-Formulare und Sortieroptionen -->
            <form method="GET">
                <input type="hidden" name="artikel" value="<?php echo htmlspecialchars($search); ?>">
                <div>
                    <label for="price_min">Preis von:</label>
                    <div class="input-container">
                        <input type="number" id="price_min" name="price_min" placeholder="Min" value="<?php echo htmlspecialchars($filters['price_min']); ?>">
                    </div>
                </div>
                <div>
                    <label for="price_max">Preis bis:</label>
                    <div class="input-container">
                        <input type="number" id="price_max" name="price_max" placeholder="Max" value="<?php echo htmlspecialchars($filters['price_max']); ?>">
                    </div>
                </div>
                <div>
                    <label for="color">Farbe:</label>
                    <select id="color" name="color">
                        <option value="">Alle</option>
                        <?php foreach ($colors as $color): ?>
                            <option value="<?php echo htmlspecialchars($color); ?>" <?php if ($filters['color'] == $color) echo 'selected'; ?>><?php echo htmlspecialchars($color); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label for="brand">Marke:</label>
                    <select id="brand" name="brand">
                        <option value="">Alle</option>
                        <?php foreach ($brands as $brand): ?>
                            <option value="<?php echo htmlspecialchars($brand); ?>" <?php if ($filters['brand'] == $brand) echo 'selected'; ?>><?php echo htmlspecialchars($brand); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label for="condition">Zustand:</label>
                    <select id="condition" name="condition">
                        <option value="">Alle</option>
                        <?php foreach ($conditions as $condition): ?>
                            <option value="<?php echo htmlspecialchars($condition); ?>" <?php if ($filters['condition'] == $condition) echo 'selected'; ?>><?php echo htmlspecialchars($condition); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label for="sort">Sortieren:</label>
                    <select name="sort" id="sort">
                        <option value="newest" <?php if ($sort == 'newest') echo 'selected'; ?>>Neueste</option>
                        <option value="price_asc" <?php if ($sort == 'price_asc') echo 'selected'; ?>>Preis aufsteigend</option>
                        <option value="price_desc" <?php if ($sort == 'price_desc') echo 'selected'; ?>>Preis absteigend</option>
                    </select>
                </div>
                <button type="submit">Filter anwenden</button>
            </form>
        </div>
        <div class="ads-list">
            <?php foreach ($ads as $ad): ?>
                <a class="ad-item-link" href="nutzer_anzeige.php?id=<?php echo $ad['id']; ?>">
                    <div class="ad-item">
                        <div class="img-container">
                            <?php $images = explode(",", $ad['image_url']); ?>
                            <?php if (count($images) > 0): ?>
                                <img src="<?php echo htmlspecialchars($images[0]); ?>" alt="Bild">
                            <?php endif; ?>
                        </div>
                        <h3><?php echo htmlspecialchars($ad['title']); ?></h3>
                        <p><?php echo htmlspecialchars($ad['description']); ?></p>
                        <p>Preis: <?php echo htmlspecialchars($ad['price']); ?>€</p>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>
