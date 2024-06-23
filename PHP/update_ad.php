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
        $sql = "UPDATE ads SET title = ?, description = ?, category = ?, price = ?, color = ?, brand = ?, `condition` = ?, image_url = ? WHERE id = ? AND user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssdsdssii", $title, $description, $category, $price, $color, $brand, $condition, $image_path, $ad_id, $user_id);
    } else {
        $sql = "UPDATE ads SET title = ?, description = ?, category = ?, price = ?, color = ?, brand = ?, `condition` = ? WHERE id = ? AND user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssdsdsii", $title, $description, $category, $price, $color, $brand, $condition, $ad_id, $user_id);
    }
    
    if ($stmt->execute()) {
        header('Location: eigenes_profil.php');
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
