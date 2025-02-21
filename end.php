<?php

session_start();

if (!isset($_SESSION) || session_status() === PHP_SESSION_NONE) {
  header("Location: https://pubz.l3dnac3k.net/login.php?failed=" . urlencode("Houstone, máme problém! :/"));
  die();
}

require $_SERVER["DOCUMENT_ROOT"] . "/utils/database.php";
require $_SERVER["DOCUMENT_ROOT"] . "/utils/uuid.php";
global $database;

if (!array_key_exists("code", $_SESSION) || empty($_SESSION["code"])) {
  header("Location: https://pubz.l3dnac3k.net/login.php?failed=" . urlencode("Nastala vyjímka, neočekávaná softwarová vyjímka... :("));
  die();
}

if (!array_key_exists("name", $_SESSION) || empty($_SESSION["name"])) {
  header("Location: https://pubz.l3dnac3k.net/login.php?failed=" . urlencode("Zažiješ Ameriku! :(") . "&game=" . $_GET["code"]);
  die();
}

$data = $database->select("Games", ["id"], ["id" => $_SESSION["code"]]);

if (count($data) == 0) {
  header("Location: https://pubz.l3dnac3k.net/login.php?failed=" . urlencode("A chčije a chčije... :("));
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

