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
  header("Location: https://pubz.infinityfreeapp.com/login.php?failed=" . urlencode("Nezadal jsi kód :/"));
  die();
}

if (array_key_exists("name", $_GET) && !empty($_GET["name"])) {
  $_SESSION["name"] = htmlspecialchars($_GET["name"]);
} else {
  header("Location: https://pubz.infinityfreeapp.com/login.php?failed=" . urlencode("Nezadal jsi jméno :/") . "&game=" . $_GET["code"]);
  die();
}

if (!empty($database->get("Players", "name", [ "name" => $_GET["name"] ]))) {
  header("Location: https://pubz.infinityfreeapp.com/login.php?failed=" . urlencode("Tohle jméno je už zabrané :/") . "&game=" . $_GET["code"]);
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
    "last_ping" => time()
  ]);
} else {
  header("Location: https://pubz.infinityfreeapp.com/login.php?failed=" . urlencode("Kód je bohužel neplatný :("));
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
      <script>if (localStorage.getItem('answers')) localStorage.removeItem('answers')</script>
      <script>

        function get_stage() { fetch('https://pubz.infinityfreeapp.com/api/get-stage.php?game=' + <?php echo $_SESSION["code"] ?>)
          .then(function (response) { return response.text(); })
          .then(function (text) {
            console.log(text);
            if (text != '0')
              window.location.replace('https://pubz.infinityfreeapp.com/game.php');
          });}
        setInterval(get_stage, 2000);

        function ping() { fetch('https://pubz.infinityfreeapp.com/api/ping-player.php')
          .then(function (response) { return response.text(); })
          .then(function (text) {
            if (text.length == 1)
              console.log("Ping: OK");
            else
              window.location.replace(encodeURI("https://pubz.infinityfreeapp.com/index.php?failed=" + text));
          })};
        setInterval(ping, 4000);

      </script>
    </div>
  </body>
</html>

