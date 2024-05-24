<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrierung</title>
    <link rel="stylesheet" href="../CSS/style.css">
    <style>
        body {
            background-image: url('../CSS/Hintergrundbild.jpg');
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
        input[type="text"] {
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
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Ort</h1>
        <form action="registrierung2.php" method="post">
            <input type="text" name="plz" placeholder="PLZ" pattern="\d{5}" title="Bitte geben Sie genau 5 Ziffern ein" required>
            <input type="text" name="ort" placeholder="Ort" pattern="[A-Za-zÄäÖöÜüß\s]+" title="Bitte geben Sie nur Buchstaben ein" required>
            <button type="submit">Weiter</button>
        </form>
    </div>
</body>
</html>
