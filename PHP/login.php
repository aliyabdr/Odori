<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../style.css">
    <style>
        body {
            background-image: url('../img/Hintergrundbild.jpg');
            margin: 0;
            padding: 0;
            font-family: Oswald, sans-serif;
            background-size: cover;
            background-position: center;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .container {
            width: 100%;
            display: flex;
            justify-content: center;
        }
        .login-box {
            background-color: rgba(255, 255, 255, 0.7);
            width: 300px;
            height: 400px;
            padding: 20px 50px;
            margin: 0 auto;
            border-radius: 10px;
            text-align: center;
            overflow: hidden;
        }
        h2 {
            font-size: 30px;
            font-weight: bold;
        }
        input[type="text"], input[type="password"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin: 10px 0px;
            border-radius: 20px;
            border: none;
            align-items: center;
        }
        button {
            background-color: rgb(163, 177, 138);
            color: white;
            padding: 10px 20px;
            margin: 10px 0px;
            border: none;
            border-radius: 20px;
            cursor: pointer;
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

    <?php
    include '../db_connect.php';

    if (isset($_POST['login'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Benutzerdaten aus der Datenbank abrufen
        $sql = "SELECT * FROM users WHERE benutzername = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            // Überprüfen, ob das eingegebene Passwort mit dem in der Datenbank übereinstimmt
            if (password_verify($password, $row['passwort'])) {
                header('Location: http://localhost/Odori/PHP/startseite.php'); // Weiterleitung zur Startseite
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
</body>
</html>

