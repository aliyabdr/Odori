<?php
    session_start(); // Startet die Session nur, wenn noch keine aktive Session vorhanden ist

// Überprüfung, ob der Benutzer eingeloggt ist
if (isset($_SESSION['user_id'])) {
    header('Location: startseite.php');
    exit; // Beendet die Skriptausführung nach der Weiterleitung
}

include '../db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Benutzerdaten aus der Datenbank abrufen
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Überprüfen, ob das eingegebene Passwort mit dem in der Datenbank übereinstimmt
        if (password_verify($password, $row['password'])) {
            // Setzen von Session-Variablen
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['user_profile_picture'] = $row['profile_picture'];
            header('Location: startseite.php'); // Weiterleitung zur Startseite
            exit; // Beendet die Skriptausführung nach der Weiterleitung
        } else {
            echo "<script>alert('Falscher Benutzername oder Passwort!');</script>";
        }
    } else {
        echo "<script>alert('Falscher Benutzername oder Passwort!');</script>";
    }

    $stmt->close();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
         /* Importiere die Schriftart 'Lato' */
         @import url('https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap');
    body {
        background-image: url('../img/Hintergrundbild.jpg');
        margin: 0;
        padding-bottom: 20px;
        font-family: 'Lato', sans-serif;
        background-size: cover;
        background-position: center;
        height: 100vh;
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    .container {
        width: 100%;
        display: flex;
        justify-content: center;
        margin-top: 5%; /* Erhöht den Abstand vom oberen Rand */
        padding-top: 2px;
    }
    .login-box {
        background-color: rgba(255, 255, 255, 0.8);
        width: 400px;
        padding: 20px;
        border-radius: 20px;
        text-align: center;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        margin-top: 30px;
        margin-bottom: 30px;
        color: black;
    }
    h2 {
        font-size: 24px;
        margin-bottom: 20px;
        color:black;
    }
    input[type="text"], input[type="password"] {
        width: calc(100% - 30px); /* Reduziert die Breite des Eingabefeldes */
        padding: 10px;
        margin: 10px 15px; /* Fügt links und rechts mehr Abstand hinzu */
        border-radius: 20px;
        border: 1px solid #ccc;
        box-sizing: border-box; /* Beinhaltet Padding in der Breite */
        color: black;
    }
    button {
        padding: 10px 20px;
        background-color: rgb(163, 177, 138);
        color: white;
        border: none;
        border-radius: 20px;
        margin-top: 10px;
        cursor: pointer;
        font-size: 16px;
    }
    a {
        color: rgb(163, 177, 138);
        text-decoration: none;
    }
    a:hover {
        text-decoration: underline;
    }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="container">
        <div class="login-box">
            <h2>Willkommen bei Odori</h2>
            <p>Logge dich ein, um gebrauchte Outdoor-Schätze zu entdecken und anzubieten.</p>
            <form method="post">
                <input type="text" name="username" placeholder="Benutzername" required>
                <input type="password" name="password" placeholder="Passwort" required>
                <button type="submit" name="login">Einloggen</button>
            </form>
            <p>Noch nicht registriert? <strong><a href="registrierung1.php">Erstelle ein Konto</a></strong></p>
        </div>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>

