<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start(); // Startet die Session nur, wenn noch keine aktive Session vorhanden ist
}

include '../db_connect.php'; // Verbindung zur Datenbank herstellen

// Überprüfung, ob der Benutzer eingeloggt ist und Benutzerdaten abrufen
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT username, profile_picture FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $_SESSION['username'] = $user['username'];
        $_SESSION['user_profile_picture'] = $user['profile_picture'];
    }

    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Odori</title>
    <style>
        .logo-img {
            max-width: 200px;
            height: auto;
        }
        header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 20px;
            background-color: #f8f8f8;
            border-bottom: 1px solid #ddd;
            position: sticky;
            top: 0;
            z-index: 1000;
            width: 100%;
            margin: 0;
            box-sizing: border-box;
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
        .user-profile {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 30px;
            height: 30px;
            background-color: #a3b18a;
            color: white;
            font-size: 16px;
            border-radius: 50%;
            text-align: center;
            cursor: pointer;
            position: relative;
        }
        .user-profile-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }
        .dropdown-content {
            display: none;
            position: absolute;
            top: 40px;
            right: 0;
            background-color: #f9f9f9;
            min-width: 100px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 10;
            border-radius: 5px;
        }
        .dropdown-content a, .dropdown-content button {
            color: black;
            padding: 12px 16px; 
            text-decoration: none;
            display: block;
            text-align: left;
            background: none;
            border: none;
            width: 100%;
            cursor: pointer;
            font-size: 14px;
            box-sizing: border-box;
        }
        .dropdown-content a:hover, .dropdown-content button:hover {
            background-color: #ddd;
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
            <a href="gespeicherte_anzeigen.php"><img src="../img/icon-fav.jpg" alt="Gespeicherte Anzeigen"></a>
            <div class="user-profile" id="userProfile">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <?php if (!empty($_SESSION['user_profile_picture'])): ?>
                        <img src="<?php echo $_SESSION['user_profile_picture']; ?>" alt="Profil" class="user-profile-img">
                    <?php else: ?>
                        <?php echo strtoupper($_SESSION['username'][0]); ?>
                    <?php endif; ?>
                    <div class="dropdown-content" id="dropdownContent">
                        <a href="eigenes_profil.php">Zum Profil</a>
                        <form method="post" action="logout.php">
                            <button type="submit" name="logout">Abmelden</button>
                        </form>
                    </div>
                <?php else: ?>
                    <a href="login.php"><img src="../img/icon-image.jpg" alt="Profil"></a>
                <?php endif; ?>
            </div>
        </div>
    </header>
    <script>
        // Funktion zum Anzeigen/Ausblenden des Dropdown-Menüs
        document.getElementById('userProfile').addEventListener('click', function(event) {
            event.stopPropagation();
            var dropdown = document.getElementById('dropdownContent');
            dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
        });

        // Funktion zum Ausblenden des Dropdown-Menüs, wenn außerhalb geklickt wird
        document.addEventListener('click', function(event) {
            var dropdown = document.getElementById('dropdownContent');
            if (dropdown.style.display === 'block') {
                dropdown.style.display = 'none';
            }
        });

        // Verhindert, dass das Dropdown-Menü verschwindet, wenn innerhalb geklickt wird
        document.getElementById('dropdownContent').addEventListener('click', function(event) {
            event.stopPropagation();
        });
    </script>
</body>
</html>
