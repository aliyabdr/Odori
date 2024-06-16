<?php
session_start(); // Start der Session am Anfang des Skripts, ohne Leerzeichen oder Zeilenumbrüche davor

// Überprüfung, ob der Benutzer eingeloggt ist
if (isset($_SESSION['user_id'])) {
    header('Location: startseite.php');
    exit; // Beendet die Skriptausführung nach der Weiterleitung
}

include '../db_connect.php';

?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrierung</title>
    <style>
          /* Importiere die Schriftart 'Lato' */
          @import url('https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap');
        body {
            background-image: url('../img/Hintergrundbild.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            font-family: 'Lato', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            text-align: center;
            width: 350px;
            margin-top: 400px;
            margin-bottom: 150px
        }
        input[type="text"] {
            width: 90%;
            padding: 10px;
            margin: 10px;
            border: 1px solid #ccc;
            border-radius: 20px;
            align-items: center;
        }
        button {
            background-color: #a3b18a;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 20px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="container">
        <h1>Ort</h1>
        <form action="registrierung2.php" method="post">
            <input type="text" name="plz" placeholder="PLZ" pattern="\d{5}" title="Bitte geben Sie genau 5 Ziffern ein" required>
            <input type="text" name="ort" placeholder="Ort" pattern="[A-Za-zÄäÖöÜüß\s]+" title="Bitte geben Sie nur Buchstaben ein" required>
            <button type="submit">Weiter</button>
        </form>
    </div>
<?php include 'footer.php'; ?>     
</body>
</html>
