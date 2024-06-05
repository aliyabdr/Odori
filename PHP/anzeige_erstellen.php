<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anzeige erstellen</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: 200px;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: left;
            color: #333;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="text"],
        textarea,
        select,
        input[type="number"],
        input[type="file"] {
            margin-bottom: 15px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 80%;
            align-self: center;
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
            
            <label for="price_type">Preistyp:</label>
            <select id="price_type" name="price_type" required>
                <option value="festpreis">Festpreis</option>
                <option value="verhandelbar">Verhandelbar</option>
                <option value="kostenlos">Kostenlos</option>
            </select>
            
            <label for="images">Bilder hochladen:</label>
            <input type="file" id="images" name="images[]" accept="image/*" multiple>
            
            <input type="submit" value="Anzeige erstellen">
        </form>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>
