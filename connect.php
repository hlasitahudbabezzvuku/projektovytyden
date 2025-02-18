<?php

if (isset($_SESSION) || session_status() !== PHP_SESSION_NONE) {
  session_destroy();
}

session_start();
require("database.php");

if (array_key_exists("name", $_GET)) {
  $_SESSION["name"] = $_GET["name"];
  header("Location: http://pubz.infinityfreeapp.com/login.php?game=" . $_GET["code"]);
}

if (array_key_exists("code", $_GET)) {
  $_SESSION["code"] = $_GET["code"];
} else {
  header("Location: http://pubz.infinityfreeapp.com/login.php");
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

