<?php
session_start();
include '../db_connect.php'; // Verbindung zur Datenbank herstellen

// Überprüfen, ob der Benutzer eingeloggt ist
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Weiterleitung zur Login-Seite, falls nicht eingeloggt
    exit;
}

$user_id = $_SESSION['user_id'];

// Benutzerinformationen abrufen
$sql = "SELECT username, profile_picture, about_me, location, postal_code FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

$conn->close();

// Standardwerte setzen, falls Felder nicht vorhanden sind
$username = isset($user['username']) ? $user['username'] : '';
$profile_picture = isset($user['profile_picture']) ? $user['profile_picture'] : '';
$about_me = isset($user['about_me']) ? $user['about_me'] : '';
$location = isset($user['location']) ? $user['location'] : '';
$postal_code = isset($user['postal_code']) ? $user['postal_code'] : '';
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil bearbeiten</title>
    <style>
        body {
            font-family: 'Lato', sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
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
            width: 100%;
        }
        input[type="text"],
        textarea {
            margin-bottom: 15px;
            margin-top: 10px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 80%;
        }
        input[type="file"] {
            margin-bottom: 15px;
        }
        input[type="submit"] {
            padding: 10px 20px;
            background-color: #a3b18a;
            color: white;
            border: none;
            border-radius: 20px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #8a9b68;
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="container">
        <h1>Profil bearbeiten</h1>
        <form action="update_profile.php" method="post" enctype="multipart/form-data">
            <label for="username">Mitgliedsname:</label>
            <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
            
            <label for="about_me">Über mich:</label>
            <textarea id="about_me" name="about_me" rows="4"><?php echo htmlspecialchars($about_me); ?></textarea>
            
            <label for="postal_code">Postleitzahl:</label>
            <input type="text" id="postal_code" name="postal_code" value="<?php echo htmlspecialchars($postal_code); ?>" required>
            
            <label for="location">Standort:</label>
            <input type="text" id="location" name="location" value="<?php echo htmlspecialchars($location); ?>" required>
            
            <label for="profile_picture">Profilbild ändern:</label>
            <input type="file" id="profile_picture" name="profile_picture">
            
            <input type="submit" value="Fertig">
        </form>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>




