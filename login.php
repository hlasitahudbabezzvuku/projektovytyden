<!DOCTYPE php>
<html lang="cz">
  <head>
    <meta charset="UTF-8">
    <title>PubZ</title>
    <?php

    session_start();

    require('Medoo.php');
    use Medoo\Medoo;

    if (!array_key_exists('database', $_SESSION)) {
      $_SESSION["database"] = new Medoo([
        'type' => 'mysql',
        'host' => 'sql105.infinityfree.com',
        'database' => 'if0_38314982_projektovy_tyden',
        'username' => 'if0_38314982',
        'password' => 'ojc0EveY78Zip',
        'command' => [
        'SET SQL_MODE=ANSI_QUOTES'
        ]
      ]);
    }

    ?>
  </head>
  <body>
    <form action="connect.php" method="GET">
      <input type="radio" name="mode" value="connect" checked>Připojit
      <input type="radio" name="mode" value="create">Vytvořit
      Přezdívka: <input type="text" name="name"><br>
      <!-- TODO: javascrpt ktery tohle pole schova pokud je vybrane "create" -->
      Kód: <input type="text" name="code"><br>
      <input type="submit">
    </form>
  </body>
</html>

