<!DOCTYPE html>
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
    <h1>PubZ</h1>
    <span><a href="login.php?mode=join">Připojit se</a></span>
    <span><a href="login.php?mode=host">Vytvořit</a></span>
    <span><a href="login.php?mode=single">Hrát sám</a></span>
  </body>
</html>

