<?php

require "database.php";
global $database;

?>

<!DOCTYPE html>
<html lang="cz">
  <head>
    <meta charset="UTF-8">
    <?php

    if (array_key_exists("mode", $_GET) && $_GET["mode"] == "host") {
      session_start();
      echo("<meta http-equiv=\"refresh\" content=\"30\" />");
    }

    ?>
    <title>PubZ</title>
  </head>
  <body>
    <?php

    if (array_key_exists("failed", $_GET)) {
      echo("<span style=\"color: #ff0000;\">" . $_GET["failed"] . "</span>");
    }

    if (array_key_exists("game", $_GET)) {
      echo(
        "<form action=\"connect.php\" method=\"GET\">" .
        "<input type=\"hidden\" name=\"code\" value=\"" . htmlspecialchars($_GET["game"]) . "\">" .
        "Přezdívka: <input type=\"text\" name=\"name\"><br>"
      );
    }
    
    elseif (array_key_exists("mode", $_GET) && $_GET["mode"] == "host") {
      if (!array_key_exists("code", $_SESSION)) {
        $code = rand(100000, 999999);

        $database->insert("Games", [
          "id" => $code
        ]);

        $_SESSION["code"] = $code;
      } else {
        $code = (int)$_SESSION["code"];
      }

      echo(
        "<img src=\"https://api.qrserver.com/v1/create-qr-code/?data=" . urlencode("http://pubz.infinityfreeapp.com/login.php?game=" . $code) . "\" alt=\"qr-code\"/>" .
        "<form action=\"monitor.php?id=" . $code . "\" method=\"GET\">" .
        number_format($code, 0, ".", " ")
      );
    }

    elseif (array_key_exists("mode", $_GET) && $_GET["mode"] == "single") {
      echo(
        "<form action=\"connect.php\" method=\"GET\">" .
        "Přezdívka: <input type=\"text\" name=\"name\"><br>"
      );
    }

    else {
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

