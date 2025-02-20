<?php

if (isset($_SESSION) || session_status() !== PHP_SESSION_NONE) {
  session_destroy();
}

require $_SERVER["DOCUMENT_ROOT"] . "/utils/database.php";
global $database;

?>

<!DOCTYPE html>
<html lang="cz">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <link href="css/index.css" rel="stylesheet" />
    <title>PubZ</title>
  </head>
  <body>
    <h1>PubZ</h1>

    <?php
    if (array_key_exists("failed", $_GET)) {
      echo("<span style=\"color: #ff0000;\">" . $_GET["failed"] . "</span>");
    }
    ?>

    <span><a href="login.php?mode=join">Připojit se</a></span>
    <span><a href="login.php?mode=host">Vytvořit</a></span>
    <span><a href="login.php?mode=single">Hrát sám</a></span>
  </body>
</html>

