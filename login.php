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
    <title>PubZ</title>
  </head>
  <body>
    <?php if (array_key_exists("failed", $_GET)) { ?>
      <span style="color: #ff0000;"><?php echo $_GET["failed"]; ?></span>
    <?php } ?>

    <?php if (array_key_exists("game", $_GET)) { ?>

      <form action="connect.php" method="GET">
      <input type="hidden" name="code" value="<?php echo htmlspecialchars($_GET['game']); ?>">
      Přezdívka: <input type="text" name="name"><br>

    <?php } elseif (array_key_exists("mode", $_GET) && $_GET["mode"] == "host") { ?>

      <?php
      $code = rand(100000, 999999);
      global $code;
      $database->insert("Games", [
        "id" => $code
      ]);
      ?>

      <img src="https://api.qrserver.com/v1/create-qr-code/?data=<?php echo urlencode('http://pubz.infinityfreeapp.com/login.php?game=' . $code) ?>" alt="qr-code"/>
      <form action="monitor.php" method="GET">
      <input type="hidden" name='id' value=<?php echo $code ?>>
      <?php echo $code ?>
      <div id="players"></div>
      <script>
        function get_players() { fetch('http://pubz.infinityfreeapp.com/api/get-players.php?game=' + <?php echo $code ?>)
        .then(function (response) { return response.text(); })
        .then(function (text) { document.getElementById('players').innerHTML = text; }); };
        setInterval(get_players, 2000);
      </script>

    <?php } elseif (array_key_exists("mode", $_GET) && $_GET["mode"] == "single") { ?>

      <form action="connect.php" method="GET">
      Přezdívka: <input type="text" name="name"><br>

    <?php } else { ?>

      <form action="connect.php" method="GET">
      Přezdívka: <input type="text" name="name"><br>
      Kód: <input type="text" name="code"><br>

    <?php } ?>

    <input type="submit" onclick='addStage(<?php echo $code ?>); generateQuestions(<?php echo $code ?>'>
    </form>
    <script src="game.js"></script>
  </body>
</html>

