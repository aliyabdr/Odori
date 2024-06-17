<?php
session_start();
include '../db_connect.php'; // Stelle sicher, dass dieser Pfad korrekt ist

// Überprüfen, ob der Benutzer eingeloggt ist
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $color = $_POST['color'];
    $brand = $_POST['brand'];
    $condition = $_POST['condition'];
    $user_id = $_SESSION['user_id'];
    
    // Bild-Upload bearbeiten
    $image_paths = [];
    $upload_directory = '../uploads/';
    
    foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
        $file_name = basename($_FILES['images']['name'][$key]);
        $target_file = $upload_directory . $file_name;
        if (move_uploaded_file($tmp_name, $target_file)) {
            $image_paths[] = $target_file;
        }
    }
    $image_paths_string = implode(',', $image_paths);

    // Die Anzeige in die Datenbank einfügen
    $sql = "INSERT INTO ads (title, description, category, price, color, brand, `condition`, image_url, user_id) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssdsdssi", $title, $description, $category, $price, $color, $brand, $condition, $image_paths_string, $user_id);
    
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




