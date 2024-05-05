<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Oswald, sans-serif;
            background-image: url('bilder/kalen-emsley-Bkci_8qcdvQ-unsplash.jpg');
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
    </style>
</head>
<body>
    <div class="container">
        <div class="login-box">
            <h2>Willkommen bei Odori</h2>
            <p>Logge dich ein, um gebrauchte Outdoor-Schätze zu entdecken und anzubieten.</p>
            <form method="post">
                <input type="text" name="username" placeholder="Email/Mitgliedsname">
                <input type="password" name="password" placeholder="Passwort">
                <button type="submit" name="login">Einloggen</button>
            </form>
            <p>Noch nicht registriert? <strong><a href="#">Erstelle ein Konto</a></strong></p>
        </div>
    </div>

    <?php
        if (isset($_POST['login'])) {
          $username = $_POST['username'];
          $password = $_POST['password'];
          // Einfache Überprüfung der Anmeldedaten
          if ($username === 'OutdoorQueen02' && $password === 'passwort') {
              header('Location:http://localhost/Odori/PHP/startseite.php'); // Weiterleitung zur Startseite
              exit; // Beendet die Skriptausführung nach der Weiterleitung
          } else {
              echo "<script>alert('Falscher Benutzername oder Passwort!');</script>";
          }
        }
    ?>
</body>
</html>
