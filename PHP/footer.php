<!DOCTYPE html>
<html lang="de">
<head>
<style>
    <meta charset="UTF-8">
    <title>Odori</title>
    footer {
    background-color: #333;
    color: white;
    padding: 20px 0;
    font-family: Arial, sans-serif;
}

.footer-container {
    display: flex;
    justify-content: space-around;
    width: 100%;
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
    width: 100px; /* Adjust the size of the logo as needed */
    margin-bottom: 10px;
}

.footer-link-title {
    color: black;
    font-weight: bold;
    margin-bottom: 5px;
}

.footer-link {
    color: grey;
    text-decoration: none;
    margin-bottom: 5px;
}

p {
    color: white;
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
                <img src="logo.png" alt="Logo" class="footer-logo">
                <p>Entdecke die größte Auswahl an gebrauchtem Outdoor-Equipment in Deutschland</p>
            </div>
            <div class="footer-column">
                <a href="#" class="footer-link-title">Über uns</a>
                <a href="#" class="footer-link">Unsere Geschichte</a>
            </div>
            <div class="footer-column">
                <a href="#" class="footer-link-title">Entdecken</a>
                <a href="#" class="footer-link">Wie funktioniert Odori?</a>
                <a href="#" class="footer-link">Artikelverifizierung</a>
                <a href="#" class="footer-link">Infoboard</a>
            </div>
            <div class="footer-column">
                <a href="#" class="footer-link-title">Hilfe-Center</a>
                <a href="#" class="footer-link">Hilfe-Center</a>
                <a href="#" class="footer-link">Verkaufen</a>
                <a href="#" class="footer-link">Kaufen</a>
                <a href="#" class="footer-link">Vertrauen und Sicherheit</a>
            </div>
        </div>
    </footer>

</body>
</html>