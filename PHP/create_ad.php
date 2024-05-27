<?php
include '../db_connect.php'; // Verbindung zur Datenbank herstellen

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $price_type = $_POST['price_type'];
    $images = $_FILES['images'];

    // Bilder hochladen und Pfade speichern
    $image_paths = [];
    $upload_directory = '../uploads/';

    foreach ($images['tmp_name'] as $key => $tmp_name) {
        $file_name = basename($images['name'][$key]);
        $target_file = $upload_directory . $file_name;
        if (move_uploaded_file($tmp_name, $target_file)) {
            $image_paths[] = $target_file;
        }
    }

    // Bilderpfade in JSON umwandeln
    $image_paths_json = json_encode($image_paths);

    // Anzeige in die Datenbank einfügen
    $sql = "INSERT INTO ads (titel, beschreibung, kategorie, preis, preistyp, bilder) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssdss", $title, $description, $category, $price, $price_type, $image_paths_json);

    if ($stmt->execute()) {
        echo "Anzeige erfolgreich erstellt!";
        header('Location: pop-up_anzeige_erstellt.php'); // Weiterleitung zur Liste der Anzeigen
        exit;
    } else {
        echo "Fehler: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Ungültige Anforderung.";
}
?>
