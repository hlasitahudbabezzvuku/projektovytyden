<?php

if (isset($_SESSION) || session_status() !== PHP_SESSION_NONE) {
  session_destroy();
}

session_start();
require("database.php");

if (array_key_exists("code", $_GET) && $$_GET["code"] != "") {
  $_SESSION["code"] = $_GET["code"];
} else {
  header("Location: http://pubz.infinityfreeapp.com/login.php?failed=true");
  die();
}

if (array_key_exists("name", $_GET) && $$_GET["name"] != "") {
  $_SESSION["name"] = $_GET["name"];
} else {
  header("Location: http://pubz.infinityfreeapp.com/login.php?falied=true;game=" . $_GET["code"]);
  die();
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

