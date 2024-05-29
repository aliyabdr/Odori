<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Startseite</title>
    <link rel="stylesheet" href="style.css">
    <?php include 'header.php'; ?>
</head>
<body class="startseite">
    <div class="container">
        <h1>Kaufe und verkaufe gebrauchtes Outdoor-Equipment – einfach, schnell und sicher</h1>
        <form action="suchergebnisse.php" method="GET">
            <div class="search-bar">
                <label for="artikel">Artikel suchen:</label>
                <input type="text" id="artikel" name="artikel" placeholder="Artikel eingeben">
            </div>
            <div class="search-bar">
                <label for="ort">Ort suchen:</label>
                <input type="text" id="ort" name="ort" placeholder="Ort oder PLZ eingeben">
            </div>
            <button type="submit">Suchen</button>
        </form>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>

