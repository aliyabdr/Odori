<?php
session_start();
include '../db_connect.php'; // Verbindet zur Datenbank

// Überprüfen, ob der Benutzer eingeloggt ist
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ad_id = $_POST['ad_id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $color = $_POST['color'];
    $brand = $_POST['brand'];
    $condition = $_POST['condition'];
    $user_id = $_SESSION['user_id'];
    
    // Bild-Upload bearbeiten
    $image_path = null;
    $upload_directory = '../uploads/';
    
    if (!empty($_FILES['image']['tmp_name'])) {
        $file_name = basename($_FILES['image']['name']);
        $target_file = $upload_directory . $file_name;
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            $image_path = $target_file;
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
