<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrierung - Schritt 2</title>
    <style>
        body {
            background-image: url('../img/Hintergrundbild.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            text-align: center;
        }
        input[type="text"], input[type="password"], input[type="email"] {
            width: 90%;
            padding: 10px;
            margin: 10px;
            border: 1px solid #ccc;
            border-radius: 20px;
            align-items: center;
        }
        button {
            background-color: #a3b18a;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 20px;
            cursor: pointer;
            align-items: center;
        }
    </style>
    <script>
        function validateForm() {
            var username = document.forms["regForm"]["username"].value;
            var password = document.forms["regForm"]["password"].value;
            var passwordRepeat = document.forms["regForm"]["password_repeat"].value;
            var usernamePattern = /^[a-zA-Z0-9]+$/;
            var passwordPattern = /^(?=.*\d)[a-zA-Z\d]{7,}$/;

            if (!usernamePattern.test(username)) {
                alert("Benutzername darf nur Buchstaben und Zahlen enthalten.");
                return false;
            }

            if (!passwordPattern.test(password)) {
                alert("Das Passwort muss mindestens 7 Zeichen lang sein und mindestens eine Zahl enthalten.");
                return false;
            }

            if (password !== passwordRepeat) {
                alert("Die Passwörter stimmen nicht überein.");
                return false;
            }

            return true;
        }
    </script>
</head>
<body>
    <div class="container">
        <h1>Benutzerdaten</h1>
        <form name="regForm" action="register.php" method="post" onsubmit="return validateForm()">
            <input type="hidden" name="plz" value="<?php echo htmlspecialchars($_POST['plz']); ?>">
            <input type="hidden" name="ort" value="<?php echo htmlspecialchars($_POST['ort']); ?>">
            <input type="text" name="username" placeholder="Benutzername" required>
            <input type="email" name="email" placeholder="E-Mail" required>
            <input type="password" name="password" placeholder="Passwort" required>
            <input type="password" name="password_repeat" placeholder="Passwort wiederholen" required>
            <button type="submit">Registrieren</button>
        </form>
    </div>
</body>
</html>


