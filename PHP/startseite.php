<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Startseite</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap');
        html, body {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: 'Lato', sans-serif;
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
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: flex-start;
            text-align: left;
            padding: 50px;
        }
        .container {
            max-width: 800px;
            padding: 20px;
            margin-top: 90px;
            margin-bottom: 50px;
        }
        h1 {
            font-size: 2.5em;
            margin-bottom: 20px;
            line-height: 1.2;
            min-height: 4em; /* Ensure the height remains constant */
        }
        form {
            display: flex;
            justify-content: flex-start;
            gap: 10px;
            flex-wrap: wrap;
        }
        .search-bar {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }
        .search-bar input {
            padding: 15px;
            font-size: 1em;
            border: none;
            border-radius: 25px;
            width: 200px;
            margin: 0 5px;
        }
        .search-bar button {
            padding: 15px 25px;
            font-size: 1em;
            border: none;
            border-radius: 25px;
            background-color: #A3B18A;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s;
            margin: 0 5px;
        }
        .search-bar button:hover {
            background-color: #8F9D70;
        }
        header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 20px;
            background-color: #f8f8f8;
            border-bottom: 1px solid #ddd;
        }
        .logo {
            max-width: 150px;
            width: 100%;
            height: auto;
        }
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
            color: #A3B18A;
        }
        .icons {
            display: flex;
            gap: 15px;
        }
        .icons a img {
            max-width: 30px;
            height: auto;
        }
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
            width: 100px;
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
            color: #A3B18A;
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
        /* Typewriter Effect */
        .typewriter-container {
            display: inline-flex;
            align-items: center;
        }
        .typewriter-dash {
            visibility: visible;
            margin-right: 5px;
        }
        .typewriter {
            display: inline-block;
            white-space: nowrap;
            overflow: hidden;
            visibility: hidden;
        }
        .typewriter.visible {
            visibility: visible;
        }
    </style>
    <?php include 'header.php'; ?>
</head>
<body class="startseite" style="background-image: url('../img/startseite.jpg'); background-size: cover; background-position: center; background-repeat: no-repeat; position: relative;">
    <div class="overlay">
        <div class="container">
            <h1>Kaufe und verkaufe <br> gebrauchtes Outdoor-Equipment <br><span class="typewriter-dash">–</span><span class="typewriter-container"><span id="typewriter" class="typewriter"></span></span></h1>
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
    <script>
        const words = ["einfach", "schnell", "sicher"];
        let wordIndex = 0;
        let charIndex = 0;
        const typeSpeed = 150;
        const eraseSpeed = 100;
        const delayBetweenWords = 1500;

        function type() {
            const typewriterElement = document.getElementById('typewriter');
            typewriterElement.classList.add('visible');
            if (charIndex < words[wordIndex].length) {
                typewriterElement.textContent += words[wordIndex].charAt(charIndex);
                charIndex++;
                setTimeout(type, typeSpeed);
            } else {
                setTimeout(erase, delayBetweenWords);
            }
        }

        function erase() {
            const typewriterElement = document.getElementById('typewriter');
            if (charIndex > 0) {
                typewriterElement.textContent = words[wordIndex].substring(0, charIndex - 1);
                charIndex--;
                setTimeout(erase, eraseSpeed);
            } else {
                typewriterElement.classList.remove('visible');
                wordIndex = (wordIndex + 1) % words.length;
                setTimeout(type, typeSpeed);
            }
        }

        document.addEventListener("DOMContentLoaded", function () {
            if (words.length) setTimeout(type, delayBetweenWords);
        });
    </script>
</body>
</html>