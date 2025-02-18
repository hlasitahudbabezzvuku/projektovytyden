<!DOCTYPE html>
<html lang="cz">
  <head>
    <meta charset="UTF-8">
    <title>PubZ</title>
    <?php

    session_start();

    require('Medoo.php');
    require_once 'database.php';
    use Medoo\Medoo;

    if (!array_key_exists('database', $_SESSION)) {
    $_SESSION["database"] = $database;
    }

    ?>
  </head>
  <body>
    <?php

    if (array_key_exists('game', $_GET)) {

      

    } elseif ($_GET["mode"] == "host") {

      $code = rand(100000, 999999);

      echo(
        "<img src=\"https://api.qrserver.com/v1/create-qr-code/?data=" . urlencode("http://pubz.infinityfreeapp.com/login.php?game=" . $code) . ";size=400x400\" alt=\"qr-code\"/>" .
        "<form action=\"monitor.php?id=" . $code . "\" method=\"GET\">" .
        number_format($code, 0, '.', ' ')
      );

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

