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
      <?php
      
      if ($_GET["mode"] == "host") {

        $code = rand(100000, 999999);

        echo("<form action=\"monitor.php?id=" . $code . "\" method=\"GET\">");
        echo(number_format($code, 0, '.', ' '));

      } elseif ($_GET["mode"] == "single") {
        echo(
          "<form action=\"connect.php\" method=\"GET\">" .
          "Přezdívka: <input type=\"text\" name=\"name\"><br>"
        );
      } else {
        echo(
          "<form action=\"connect.php\" method=\"GET\">" .
          "Přezdívka: <input type=\"text\" name=\"name\"><br>" .
          "Kód: <input type=\"text\" name=\"code\"><br>"
        ); 
      }     
      ?>
      <input type="submit">
    </form>
  </body>
</html>

