<!DOCTYPE php>
<html lang="cz">
  <head>
    <meta charset="UTF-8">
    <title>PubZ</title>
    <?php

    require('Medoo.php');
    use Medoo\Medoo;

    $database = new Medoo([
    'type' => 'mysql',
    'host' => 'sql105.infinityfree.com',
    'database' => 'if0_38314982_projektovy_tyden',
    'username' => 'if0_38314982',
    'password' => 'ojc0EveY78Zip',
    'command' => [
    'SET SQL_MODE=ANSI_QUOTES'
    ]
    ]);

    echo("Nevim");
    ?>

  </head>
  <body>

  </body>
</html>

