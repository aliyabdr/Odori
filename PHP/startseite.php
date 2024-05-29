<!DOCTYPE html>
<html>
<head>
    <title>Startseite</title>
    <style>
        .container {
            text-align: center;
            margin-top: 100px;
        }
        .search-bar {
            margin-bottom: 20px;
        }
    </style>
    <?php include 'header.php'; 
    include 'footer.php';
    ?>
</head>
<body>
    <div class="container">
        <h1>Kaufe und verkaufe gebrauchtes Outdoor-Equipment 
        – einfach, schnell und sicher</h1>
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
</body>
</html>
