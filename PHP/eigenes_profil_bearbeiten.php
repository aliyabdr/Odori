<?php
session_start();
include '../db_connect.php'; // Verbindung zur Datenbank herstellen

// Überprüfen, ob der Benutzer eingeloggt ist
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Weiterleitung zur Login-Seite, falls nicht eingeloggt
    exit;
}

$user_id = $_SESSION['user_id'];

try {
    // Benutzerinformationen abrufen
    $sql = "SELECT username, profile_picture, location, postal_code FROM users WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Standardwerte setzen, falls Felder nicht vorhanden sind
    $username = $user['username'] ?? '';
    $profile_picture = $user['profile_picture'] ?? '';
    $location = $user['location'] ?? '';
    $postal_code = $user['postal_code'] ?? '';
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit;
}

$pdo = null; // Verbindung schließen
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
            max-width: 1000px;
            margin: 50px auto;
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
            width: 100%;
        }
        input[type="text"],
        textarea {
            margin-bottom: 15px;
            margin-top: 10px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 100%;
            max-width: 95%;
            color: black;
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
        @media (max-width: 1000px) {
            .container {
                width: 90%;
                margin: 20px auto;
                padding: 10px;
            }
            h1 {
                font-size: 1.5em;
            }
        }
        @media (max-width: 600px) {
            h1 {
                font-size: 1.2em;
                text-align: center;
            }
            form {
                width: 100%;
                padding: 0;
            }
            input[type="submit"] {
                width: 100%;
            }
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




