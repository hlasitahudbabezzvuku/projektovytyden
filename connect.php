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
    "stage_finished" => false,
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>PubZ</title>
    <link href="css/index.css" rel="stylesheet" />
  </head>
  <body class="wait-page">
    <div class="wait-card">
      <h1>Vyčkejte na začátek hry</h1>
      <script>
      function get_stage() { fetch('http://pubz.infinityfreeapp.com/api/get-stage.php?game=' + <?php echo $_SESSION["code"] ?>)
        .then(function (response) { return response.text(); })
        .then(function (text) {
          console.log(text);
          if (text != '0')
            window.location.replace('http://pubz.infinityfreeapp.com/game.php');
        });}
      setInterval(ping, 2000);

      // frantovo - nesahat!
      function ping() { fetch('http://pubz.infinityfreeapp.com/api/ping.php')
        .then(function (response) { return response.text(); })
        .then(function (text) { console.log('ping' + text); })};
      setInterval(get_players, 10000);

      </script>
    </div>
  </body>
</html>

