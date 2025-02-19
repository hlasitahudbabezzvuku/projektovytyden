<?php

if (isset($_SESSION) || session_status() !== PHP_SESSION_NONE) {
  session_destroy();
}

session_start();
require $_SERVER["DOCUMENT_ROOT"] . "/utils/database.php";
require $_SERVER["DOCUMENT_ROOT"] . "/utils/uuid.php";
global $database;

if (array_key_exists("code", $_GET) && !empty($_GET["code"])) {
  $_SESSION["code"] = htmlspecialchars($_GET["code"]);
} else {
  header("Location: http://pubz.infinityfreeapp.com/login.php?failed=" . urlencode("Nezadal jsi kód :("));
  die();
}

if (array_key_exists("name", $_GET) && !empty($_GET["name"])) {
  $_SESSION["name"] = htmlspecialchars($_GET["name"]);
} else {
  header("Location: http://pubz.infinityfreeapp.com/login.php?failed=" . urlencode("Nezadal jsi jméno :(") . "&game=" . $_GET["code"]);
  die();
}

$uuid = uuidb();
$_SESSION["uuid"] = $uuid;

$data = $database->select("Games", ["id"], ["id" => $_SESSION["code"]]);

if (count($data) != 0) {
  $database->insert("Players", [
    "id" => $uuid,
    "name" => $_SESSION["name"],
    "game" => $_SESSION["code"],
  ]);
} else {
  header("Location: http://pubz.infinityfreeapp.com/login.php?failed=" . urlencode("Kód je bohužel neplatný :("));
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
    <span>Vyčkejte na začátek hry.</span>
    <script>
    function get_stage() { fetch('http://pubz.infinityfreeapp.com/api/get-stage.php?game=" . $code . "')
      .then(function (response) { return response.text(); })
      .then(function (text) {
        console.log(text);
        //if (text != '0')
        //  window.location.replace('http://pubz.infinityfreeapp.com/game.php');
      });}
    setInterval(get_stage, 2000);
    </script>
  </body>
</html>

