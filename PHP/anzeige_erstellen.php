<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anzeige erstellen</title>

</head>
<body>
    <h1>Anzeige erstellen</h1>
    <form action="create_ad.php" method="post" enctype="multipart/form-data">
        <label for="title">Titel:</label><br>
        <input type="text" id="title" name="title" required><br>
        
        <label for="description">Beschreibung:</label><br>
        <textarea id="description" name="description" rows="4" cols="50" required></textarea><br>
        
        <label for="category">Kategorie:</label><br>
        <select id="category" name="category" required>
            <option value="Wandern">Wandern</option>
            <option value="Camping">Camping</option>
            <option value="Klettern">Klettern</option>
            <option value="Radfahren">Radfahren</option>
            <!-- Weitere Kategorien hier hinzufügen -->
        </select><br>
        
        <label for="price">Preis:</label><br>
        <input type="number" id="price" name="price" min="0" step="0.01" required><br>
        
        <label for="price_type">Preistyp:</label><br>
        <select id="price_type" name="price_type" required>
            <option value="festpreis">Festpreis</option>
            <option value="verhandelbar">Verhandelbar</option>
            <option value="kostenlos">Kostenlos</option>
        </select><br>
        
        <label for="images">Bilder hochladen:</label><br>
        <input type="file" id="images" name="images[]" accept="image/*" multiple><br><br>
        
        <input type="submit" value="Anzeige erstellen">
    </form>
</body>
</html>
