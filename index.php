<?php

if (isset($_SESSION) || session_status() !== PHP_SESSION_NONE) {
  session_destroy();
}

if (array_key_exists("failed", $_GET)) {
  echo("<span style=\"color: #ff0000;\">" . $_GET["failed"] . "</span>");
}

require $_SERVER["DOCUMENT_ROOT"] . "/utils/database.php";
global $database;

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
    <?php if (false) { ?>
    <span><a href="login.php?mode=host">Vytvořit</a></span>
    <?php } ?>
    <span><a href="login.php?mode=single">Hrát sám</a></span>
  </body>
</html>

