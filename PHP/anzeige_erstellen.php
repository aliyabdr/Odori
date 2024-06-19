<?php
session_start(); // Startet die Sitzung

// Überprüfen, ob der Benutzer angemeldet ist
if (!isset($_SESSION['user_id'])) {
    // Wenn der Benutzer nicht angemeldet ist, Weiterleitung zur Login-Seite
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anzeige erstellen</title>
    <style>
         /* Importiere die Schriftart 'Lato' */
         @import url('https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap');
        body {
            font-family: 'Lato', sans-serif;
            padding: 20px;
            background-color: #f0f0f0;
        }
        .container {
            width: 800px; 
            margin: 50px auto; /* zentriert den Container */
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
            width: 100%; /* Etiketten auf die volle Breite setzen */
        }
        input[type="text"],
        textarea,
        select,
        input[type="number"],
        input[type="file"] {
            margin-top: 10px;
            margin-bottom: 15px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 80%; /* Eingabefelder auf volle Breite setzen */
            color: black;
        }
        input[type="submit"] {
            padding: 10px 20px;
            background-color: #a3b18a;
            color: white;
            border: none;
            border-radius: 20px;
            cursor: pointer;
            width: fit-content;
            align-self: center;
        }
        input[type="submit"]:hover {
            background-color: #8a9b68;
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="container">
        <h1>Anzeige erstellen</h1>
        <form action="create_ad.php" method="post" enctype="multipart/form-data">
            <label for="title">Titel:</label>
            <input type="text" id="title" name="title" required>
            
            <label for="description">Beschreibung:</label>
            <textarea id="description" name="description" rows="4" required></textarea>
            
            <label for="category">Kategorie:</label>
            <select id="category" name="category" required>
                <option value="Wandern">Wandern</option>
                <option value="Camping">Camping</option>
                <option value="Klettern">Klettern</option>
                <option value="Radfahren">Radfahren</option>
                <!-- Weitere Kategorien hier hinzufügen -->
            </select>
            
            <label for="price">Preis:</label>
            <input type="number" id="price" name="price" min="0" step="0.01" required>
            
            <label for="color">Farbe:</label>
            <input type="text" id="color" name="color">
            
            <label for="brand">Marke:</label>
            <input type="text" id="brand" name="brand">
            
            <label for="condition">Zustand:</label>
            <select id="condition" name="condition" required>
                <option value="neu">Neu</option>
                <option value="gebraucht">Gebraucht</option>
            </select>
            
            <label for="images">Bilder hochladen:</label>
            <input type="file" id="images" name="images[]" accept="image/*" multiple>
            
            <input type="submit" value="Anzeige erstellen">
        </form>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>


