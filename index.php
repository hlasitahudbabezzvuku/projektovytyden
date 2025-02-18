<?php


if (isset($_SESSION) || session_status() !== PHP_SESSION_NONE) {
  session_destroy();
}

require "database.php";

?>

<!DOCTYPE html>
<html lang="cz">
  <head>
    <meta charset="UTF-8">
    <title>PubZ</title>
  </head>
  <body>
    <h1>PubZ</h1>
    <span><a href="login.php?mode=join">Připojit se</a></span>
    <span><a href="login.php?mode=host">Vytvořit</a></span>
    <span><a href="login.php?mode=single">Hrát sám</a></span>
  </body>
</html>

