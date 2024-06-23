<?php
session_start();
include '../db_connect.php'; // Verbindet zur Datenbank

// Überprüfen, ob der Benutzer eingeloggt ist
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$ad_id = $_GET['id'] ?? 0;

// Anzeige-Daten abrufen
$sql = "SELECT * FROM ads WHERE id = ? AND user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $ad_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();
$ad = $result->fetch_assoc();

if (!$ad) {
    echo "Anzeige nicht gefunden oder Sie haben keine Berechtigung, diese Anzeige zu bearbeiten.";
    exit;
}
$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anzeige bearbeiten</title>
    <style>
         /* Importiere die Schriftart 'Lato' */
         @import url('https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap');
        body {
            font-family: 'Lato', sans-serif;
            padding: 0;
            margin: 0;
            background-color: #f0f0f0;
        }
        .container {
            width: 800px; 
            margin: 50px auto; /* zentriert den Container */
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            color: black;
        }
        h1 {
            text-align: left;
            color: black;
        }
        form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        label {
            margin-bottom: 5px;
            font-weight: bold;
            width: 100%; /* Etiketten auf die volle Breite setzen */
        }
        input[type="text"],
        textarea,
        select,
        input[type="number"],
        input[type="file"] {
            margin-top: 10px;
            margin-bottom: 15px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 80%; /* Eingabefelder auf volle Breite setzen */
            color: black;
        }
        input[type="submit"] {
            padding: 10px 20px;
            background-color: #a3b18a;
            color: white;
            border: none;
            border-radius: 20px;
            cursor: pointer;
            width: fit-content;
            align-self: center;
        }
        input[type="submit"]:hover {
            background-color: #8a9b68;
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="container">
        <h1>Anzeige bearbeiten</h1>
        <form action="update_ad.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="ad_id" value="<?php echo htmlspecialchars($ad['id']); ?>">
            
            <label for="title">Titel:</label>
            <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($ad['title']); ?>" required>
            
            <label for="description">Beschreibung:</label>
            <textarea id="description" name="description" rows="4" required><?php echo htmlspecialchars($ad['description']); ?></textarea>
            
            <label for="category">Kategorie:</label>
            <select id="category" name="category" required>
                <option value="Wandern" <?php if ($ad['category'] == 'Wandern') echo 'selected'; ?>>Wandern</option>
                <option value="Camping" <?php if ($ad['category'] == 'Camping') echo 'selected'; ?>>Camping</option>
                <option value="Klettern" <?php if ($ad['category'] == 'Klettern') echo 'selected'; ?>>Klettern</option>
                <option value="Radfahren" <?php if ($ad['category'] == 'Radfahren') echo 'selected'; ?>>Radfahren</option>
                <!-- Weitere Kategorien hier hinzufügen -->
            </select>
            
            <label for="price">Preis:</label>
            <input type="number" id="price" name="price" value="<?php echo htmlspecialchars($ad['price']); ?>" min="0" step="0.01" required>
            
            <label for="color">Farbe:</label>
            <input type="text" id="color" name="color" value="<?php echo htmlspecialchars($ad['color']); ?>">
            
            <label for="brand">Marke:</label>
            <input type="text" id="brand" name="brand" value="<?php echo htmlspecialchars($ad['brand']); ?>">
            
            <label for="condition">Zustand:</label>
            <select id="condition" name="condition" required>
                <option value="neu" <?php if ($ad['condition'] == 'neu') echo 'selected'; ?>>Neu</option>
                <option value="gebraucht" <?php if ($ad['condition'] == 'gebraucht') echo 'selected'; ?>>Gebraucht</option>
            </select>
            
            <label for="image">Bild ändern:</label>
            <input type="file" id="image" name="image" accept="image/*">
            
            <input type="submit" value="Anzeige aktualisieren">
        </form>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>

