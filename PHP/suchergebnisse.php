<?php
// Fehlerberichterstattung aktivieren
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Datenbank-Verbindung
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kleinanzeigenplattform";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Verbindung fehlgeschlagen: " . $conn->connect_error);
}

// Suchbegriff und Ort abrufen
$artikel = isset($_GET['artikel']) ? trim($_GET['artikel']) : '';
$ort = isset($_GET['ort']) ? trim($_GET['ort']) : '';

// Überprüfen, ob der Suchbegriff (artikel) ein Pflichtfeld ist
if (empty($artikel)) {
    echo "Bitte geben Sie einen Suchbegriff ein.";
    $conn->close();
    exit();
}

// SQL-Abfrage basierend auf den Eingaben
if (!empty($ort)) {
    $sql = "SELECT * FROM ads WHERE (titel LIKE '%$artikel%' OR beschreibung LIKE '%$artikel%') AND beschreibung LIKE '%$ort%'";
} else {
    $sql = "SELECT * FROM ads WHERE titel LIKE '%$artikel%' OR beschreibung LIKE '%$artikel%'";
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Suchergebnisse</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="results">
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<div class='product'>";
                echo "<img src='" . $row['bilder'] . "' alt='" . $row['titel'] . "'>";
                echo "<h2>" . $row['titel'] . "</h2>";
                echo "<p>" . $row['beschreibung'] . "</p>";
                echo "<p class='price'>" . $row['preis'] . " " . $row['preistyp'] . "</p>";
                echo "<p class='location'>" . $row['erstellt_am'] . "</p>";
                echo "</div>";
            }
        } else {
            echo "Keine Ergebnisse gefunden";
        }
        $conn->close();
        ?>
    </div>
</body>
</html>



