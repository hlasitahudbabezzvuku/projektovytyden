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
    <span><a href="connect.php">Jeden Hráč</a></span>
    <span><a href="connect.php">Více Hráčů</a></span>
  </body>
</html>

