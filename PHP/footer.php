<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Odori</title>
    <link rel="stylesheet" href="../style.css">
    <style>
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
</head>
<body>
    <footer>
        <div class="footer-container">
            <div class="footer-column">
                <img src="../img/odori-logo-quer.png" alt="Logo" class="footer-logo">
                <p>Entdecke die größte Auswahl an gebrauchtem <br> Outdoor-Equipment in Deutschland</p>
            </div>
            <div class="footer-column">
                <h4 class="footer-link-title">Über uns</h4>
                <a href="#" class="footer-link">Karriere</a>
                <a href="#" class="footer-link">Nachhaltigkeit</a>
                <a href="#" class="footer-link">Presse</a>
                <a href="#" class="footer-link">Werbung</a>
            </div>
            <div class="footer-column">
                <h4 class="footer-link-title">Entdecken</h4>
                <a href="#" class="footer-link">Wie funktioniert?</a>
                <a href="#" class="footer-link">Artikelverifizierung</a>
                <a href="#" class="footer-link">Smartphone-Apps</a>
                <a href="#" class="footer-link">Infoboard</a>
            </div>
            <div class="footer-column">
                <h4 class="footer-link-title">Hilfe</h4>
                <a href="#" class="footer-link">Hilfe-Center</a>
                <a href="#" class="footer-link">Verkaufen</a>
                <a href="#" class="footer-link">Vertrauen und Sicherheit</a>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2024 Odori</p>
        </div>
    </footer>
</body>
</html>
