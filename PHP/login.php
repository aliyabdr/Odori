<!DOCTYPE html>
<html lang="de">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
    <link rel="stylesheet" href="styles.css" />
  </head>
  <body>
    <header>
      <nav>
        <ul>
          <li><a href="index.html">Startseite</a></li>
          <li><a href="uebermich.html">Über mich</a></li>
          <li><a href="impressum.html">Impressum</a></li>
          <li><a href="login.html">Login</a></li>
        </ul>
      </nav>
    </header>
    <main>
      <h1>Login</h1>
      <form action="login_do.php" method="POST">
        <div>
          <label for="username">Benutzername:</label>
          <input type="text" id="username" name="username" required />
        </div>
        <div>
          <label for="password">Passwort:</label>
          <input type="password" id="password" name="password" required />
        </div>
        <button type="submit">Anmelden</button>
      </form>
    </main>
    <footer>
      <!-- Footer-Inhalt hier einfügen -->
    </footer>
  </body>
</html>
