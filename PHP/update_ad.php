<?php
session_start();
include '../db_connect.php'; // Verbindung zur Datenbank herstellen

// Funktion zum Escapen von HTML-Ausgabe
function escape($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

// Überprüfen, ob der Benutzer eingeloggt ist
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ad_id = trim($_POST['ad_id']);
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $category = trim($_POST['category']);
    $price = trim($_POST['price']);
    $color = trim($_POST['color']);
    $brand = trim($_POST['brand']);
    $condition = trim($_POST['condition']);
    $user_id = $_SESSION['user_id'];
    
    // Eingabedaten überprüfen
    if (empty($ad_id) || empty($title) || empty($description) || empty($category) || empty($price) || empty($color) || empty($brand) || empty($condition)) {
        echo "Alle Felder sind erforderlich.";
        exit;
    }
    
    // Bild-Upload bearbeiten
    $image_path = null;
    $upload_directory = '../uploads/';
    $allowed_file_types = ['jpg', 'jpeg', 'png', 'gif'];
    
    if (!empty($_FILES['image']['tmp_name'])) {
        $imageFileType = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        if (in_array($imageFileType, $allowed_file_types)) {
            $check = getimagesize($_FILES['image']['tmp_name']);
            if ($check !== false) {
                // Bilddatei ist ein Bild
                $new_filename = uniqid() . '.' . $imageFileType;
                $target_file = $upload_directory . $new_filename;
                if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
                    $image_path = $target_file;
                } else {
                    echo "Fehler beim Hochladen des Bildes.";
                    exit;
                }
            } else {
                echo "Die Datei ist kein gültiges Bild.";
                exit;
            }
        } else {
            echo "Ungültiger Dateityp. Erlaubt sind nur JPG, JPEG, PNG und GIF.";
            exit;
        }
    }

    // Die Anzeige in der Datenbank aktualisieren
    if ($image_path) {
        $sql = "UPDATE ads SET title = :title, description = :description, category = :category, price = :price, color = :color, brand = :brand, `condition` = :condition, image_url = :image_url WHERE id = :id AND user_id = :user_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':title' => $title,
            ':description' => $description,
            ':category' => $category,
            ':price' => $price,
            ':color' => $color,
            ':brand' => $brand,
            ':condition' => $condition,
            ':image_url' => $image_path,
            ':id' => $ad_id,
            ':user_id' => $user_id
        ]);
    } else {
        $sql = "UPDATE ads SET title = :title, description = :description, category = :category, price = :price, color = :color, brand = :brand, `condition` = :condition WHERE id = :id AND user_id = :user_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':title' => $title,
            ':description' => $description,
            ':category' => $category,
            ':price' => $price,
            ':color' => $color,
            ':brand' => $brand,
            ':condition' => $condition,
            ':id' => $ad_id,
            ':user_id' => $user_id
        ]);
    }
    
    if ($stmt->rowCount() > 0) {
        header('Location: eigenes_profil.php');
        exit();
    } else {
        echo "Error: Die Anzeige konnte nicht aktualisiert werden.";
    }
}
?>

