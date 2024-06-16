<?php
    session_start(); // Startet die Session nur, wenn noch keine aktive Session vorhanden ist
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Startseite</title>
    <style>
        /* Importiere die Schriftart 'Lato' */
        @import url('https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap');

        /* Grundlegendes Layout und Stile */
        html, body {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: 'Lato', sans-serif; /* Anwenden der Schriftart 'Lato' */
        }

        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            color: white;
        }

        body.startseite {
            flex: 1;
            position: relative;
            background-image: url('../img/startseite.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .overlay {
            position: relative;
            flex: 1;
            background: rgba(0, 0, 0, 0.5); /* Dunkler Overlay für besseren Kontrast */
            display: flex;
            flex-direction: column; /* Ensures vertical alignment */
            justify-content: center; /* Centers content vertically */
            align-items: flex-start; /* Aligns content to the left */
            text-align: left; /* Aligns text to the left */
            padding: 50px; /* Abstand von den Rändern */
        }

        .container {
            max-width: 800px;
            padding: 20px;
            margin-top: 50px; /* Adds space above the container */
            margin-bottom: 50px; /* Adds space below the container */
        }

        h1 {
            font-size: 2.5em;
            margin-bottom: 20px;
            line-height: 1.2; /* Linienhöhe für bessere Lesbarkeit */
        }

        form {
            display: flex;
            justify-content: flex-start; /* Aligns form to the left */
            gap: 10px;
            flex-wrap: wrap; /* Zeilenumbruch bei kleineren Bildschirmen */
        }

        .search-bar {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }

        .search-bar input {
            padding: 15px; /* Mehr Padding für größere Felder */
            font-size: 1em;
            border: none;
            border-radius: 25px; /* Runde Ecken */
            width: 200px;
            margin: 0 5px; /* Mehr Rand */
        }

        .search-bar button {
            padding: 15px 25px;
            font-size: 1em;
            border: none;
            border-radius: 25px; /* Runde Ecken */
            background-color: #A3B18A; /* Anpassung der Farbe */
            color: white; /* Schriftfarbe */
            cursor: pointer;
            transition: background-color 0.3s;
            margin: 0 5px; /* Mehr Rand */
        }

        .search-bar button:hover {
            background-color: #8F9D70;
        }

        /* Header-Stile */
        header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 20px;
            background-color: #f8f8f8;
            border-bottom: 1px solid #ddd;
        }

        /* Logo-Stile */
        .logo {
            max-width: 150px;
            width: 100%;
            height: auto;
        }

        /* Navigation-Stile */
        .navigation ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
            gap: 15px;
        }

        .navigation ul li {
            display: inline;
        }

        .navigation ul li a {
            text-decoration: none;
            color: #333;
            padding: 10px 15px;
            transition: color 0.3s;
        }

        .navigation ul li a:hover {
            color: #A3B18A; /* Anpassung der Farbe auf Hover */
        }

        /* Icons-Stile */
        .icons {
            display: flex;
            gap: 15px;
        }

        .icons a img {
            max-width: 30px;
            height: auto;
        }

        /* Footer-Stile */
        footer {
            background-color: #f8f8f8;
            color: #333;
            padding: 20px 0;
            font-family: Arial, sans-serif;
            text-align: center;
            width: 100%;
            margin-top: auto;
        }

        .footer-container {
            display: flex;
            justify-content: space-around;
            max-width: 1200px;
            margin: auto;
        }

        .footer-column {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            padding: 10px;
        }

        .footer-logo {
            width: 100px; /* Größe des Logos anpassen */
            margin-bottom: 10px;
        }

        .footer-link-title {
            color: #333;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .footer-link {
            color: #666;
            text-decoration: none;
            margin-bottom: 5px;
        }

        .footer-link:hover {
            color: #A3B18A; /* Anpassung der Farbe auf Hover */
        }

        .footer-bottom {
            padding: 10px 0;
            background-color: #e1e1e1;
            width: 100%;
        }

        .footer-bottom p {
            margin: 0;
            color: #333;
        }

        @media (max-width: 768px) {
            .footer-container {
                flex-direction: column;
                align-items: center;
            }

            .footer-column {
                align-items: center;
                margin-bottom: 20px;
            }
        }
    </style>
    <?php include 'header.php'; ?>
</head>
<body class="startseite" style="background-image: url('../img/startseite.jpg'); background-size: cover; background-position: center; background-repeat: no-repeat; position: relative;">
    <div class="overlay">
        <div class="container">
            <h1>Kaufe und verkaufe <br> gebrauchtes Outdoor-Equipment <br>– einfach, schnell und sicher</h1>
            <form action="suchergebnisse.php" method="GET">
                <div class="search-bar">
                    <input type="text" id="artikel" name="artikel" placeholder="Was suchst du?">
                    <input type="text" id="ort" name="ort" placeholder="Postleitzahl / Ort">
                    <button type="submit">Finden</button>
                </div>
            </form>
        </div>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>
