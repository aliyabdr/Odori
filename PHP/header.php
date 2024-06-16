<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Odori</title>
    <link rel="stylesheet" href="../style.css">
    <style>
        .logo-img {
            max-width: 200px; /* Größe des Logos anpassen */
            height: auto; /* Seitenverhältnis beibehalten */
        }

        /* Header-Stile */
        header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 20px;
            background-color: #f8f8f8;
            border-bottom: 1px solid #ddd;
            position: sticky;
            top: 0;
            z-index: 1000; /* Stellt sicher, dass der Header über anderen Inhalten bleibt */
            width: 100%;
            margin: 0;
            box-sizing: border-box; /* Stellt sicher, dass Padding im Gesamtbreitenwert enthalten ist */
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
    </style>
</head>
<body>
    <header>
        <div class="logo">
            <a href="startseite.php">
                <img src="../img/odori-logo-quer.png" alt="Logo" class="logo-img">
            </a>
        </div> 
        <nav class="navigation">
            <ul>
                <li><a href="bekleidung.php">BEKLEIDUNG</a></li>
                <li><a href="ausruestung.php">AUSRÜSTUNG</a></li>
                <li><a href="aktivitaeten.php">AKTIVITÄTEN</a></li>
                <li><a href="marken.php">MARKEN</a></li>
            </ul>
        </nav>
        <div class="icons">
            <a href="anzeige_erstellen.php"><img src="../img/icon-add.jpg" alt="Anzeige erstellen"></a>
            <a href="chat.php"><img src="../img/icon-speech-bubble.jpg" alt="Chat"></a>
            <a href="gespeichert.php"><img src="../img/icon-fav.jpg" alt="Gespeicherte Anzeigen"></a>
            <a href="profil.php"><img src="../img/icon-image.jpg" alt="Profil"></a>
        </div>
    </header>
</body>
</html>

