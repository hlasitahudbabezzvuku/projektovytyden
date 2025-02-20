<?php

require $_SERVER["DOCUMENT_ROOT"] . "/utils/database.php";

session_start();

if (!array_key_exists("code", $_SESSION)) {
  header("Location: http://pubz.infinityfreeapp.com/index.php?failed=" . urlencode("Je nutné nejprve hru vytvořit"));
} 

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <script src="game.js"></script>
    <title>PubZ</title>
  </head>
  <body>
    <button onclick="nextStage(<?php echo $_SESSION['code'] ?>)" 
    id="continue-button" disabled>Continue</button>
    <?php if (isset($_GET['startGame'])) {?>
      <script>startGame(<?php echo $_SESSION['code']?>)</script>
    <?php } ?>
    <script>let gameInterval = setInterval(checkFinished, 2000, <?php echo $_SESSION["code"] ?>)</script>
    <script>let scoreboardInterval = setInterval(getFinishedPlayers, 2000, <?php echo $_SESSION["code"] ?>)</script>

    <!--Frantovo nesahat!-->
    <script>

      function ping() { fetch('http://pubz.infinityfreeapp.com/api/ping-game.php')
        .then(function (response) { return response.text(); })
        .then(function (text) {
          if (text.length == 1)
            console.log("Ping: OK");
          else
            window.location.replace(encodeURI("http://pubz.infinityfreeapp.com/index.php?failed=" + text));
        })};
      setInterval(ping, 5000);

    </script>

    <div id='score-board'></div>
  </body>
</html>
