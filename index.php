<!DOCTYPE html>
<html lang="cz">
  <head>
    <meta charset="UTF-8">
    <title>PubZ</title>
    <?php

    session_start();

    require('Medoo.php');
    require 'database.php';
    use Medoo\Medoo;

    if (!array_key_exists('database', $_SESSION)) {
      $_SESSION["database"] = $database;
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

