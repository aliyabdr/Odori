<?php
session_start();
include '../db_connect.php'; // Verbindung zur Datenbank herstellen

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

    // Benutzerinformationen aus der Datenbank abrufen
    $sql_user = "SELECT location FROM users WHERE id = ?";
    $stmt_user = $conn->prepare($sql_user);
    $stmt_user->bind_param("i", $user_id);
    $stmt_user->execute();
    $result_user = $stmt_user->get_result();
    $user = $result_user->fetch_assoc();
    $stmt_user->close();

    $location = $user['location'];
    
    // Bild-Upload bearbeiten
    $upload_directory = '../uploads/';
    $file_name = basename($_FILES['images']['name'][0]);
    $target_file = $upload_directory . $file_name;
    if (move_uploaded_file($_FILES['images']['tmp_name'][0], $target_file)) {
        $image_url = $target_file;
    } else {
        $image_url = ''; // Setze einen leeren String, wenn der Bild-Upload fehlschlägt
    }

    // Die Anzeige in die Datenbank einfügen
    $sql = "INSERT INTO ads (title, description, category, price, color, brand, `condition`, image_url, user_id, location) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssdsdssis", $title, $description, $category, $price, $color, $brand, $condition, $image_url, $user_id, $location);
    
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





