<?php

if (isset($_SESSION) || session_status() !== PHP_SESSION_NONE) {
  session_destroy();
}

session_start();
require("database.php");

if (array_key_exists("name", $_GET)) {
  $_SESSION["name"] = $_GET["name"];
}

if (array_key_exists("code", $_GET)) {
  $_SESSION["code"] = $_GET["code"];
  echo(htmlspecialchars($_GET["name"]));
  echo(htmlspecialchars($_GET["code"]));
} else {
  header('Location: http://pubz.infinityfreeapp.com');
}

?>

<!DOCTYPE html>
<html lang="cz">
  <head>
    <meta charset="UTF-8">
    <title>PubZ</title>
  </head>
  <body>
  </body>
</html>

