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

    try {
        // Benutzerinformationen aus der Datenbank abrufen
        $sql_user = "SELECT location FROM users WHERE id = :id";
        $stmt_user = $pdo->prepare($sql_user);
        $stmt_user->bindParam(':id', $user_id, PDO::PARAM_INT);
        $stmt_user->execute();
        $user = $stmt_user->fetch(PDO::FETCH_ASSOC);
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
        $sql = "INSERT INTO ads (title, description, category, price, color, brand, `condition`, image_url, user_id) 
                VALUES (:title, :description, :category, :price, :color, :brand, :condition, :image_url, :user_id)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        $stmt->bindParam(':category', $category, PDO::PARAM_STR);
        $stmt->bindParam(':price', $price, PDO::PARAM_STR);
        $stmt->bindParam(':color', $color, PDO::PARAM_STR);
        $stmt->bindParam(':brand', $brand, PDO::PARAM_STR);
        $stmt->bindParam(':condition', $condition, PDO::PARAM_STR);
        $stmt->bindParam(':image_url', $image_url, PDO::PARAM_STR);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        
        if ($stmt->execute()) {
            header('Location: eigenes_profil.php');
            exit();
        } else {
            echo "Error: " . $stmt->errorInfo()[2];
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

$pdo = null;
?>






