<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Startseite</title>
    <link rel="stylesheet" href="../style.css">
    <?php include 'header.php'; ?>
</head>
<body class="startseite" style="background-image: url('../img/startseite.jpg'); background-size: cover; background-position: center; background-repeat: no-repeat; position: relative;">
    <div class="overlay">
        <div class="container">
            <h1>Kaufe und verkaufe gebrauchtes Outdoor-Equipment – einfach, schnell und sicher</h1>
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
