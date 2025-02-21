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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PubZ</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;600;700&display=swap" rel="stylesheet"/>
    <link href="css/monitor.css" rel="stylesheet"/>
  </head>


  <body>
    <div class="logo">
      <a href="index.html">
        <img src="ada.png" alt="PUBS logo" />
      </a>
    </div>
    <div class="container show">
      <h1>Výsledky hráčů</h1>
      <p>Celkové skóre všech hráčů:</p>
      <div style="overflow-x: auto;">
        <table>
          <thead>
            <tr>
              <th>Jméno</th>
              <th>Progres</th>
            </tr>
          </thead>
          <tbody id='score-board'>
          </tbody>
        </table>
      </div>
    </div>
  </body>


  <body>
    <script src="game.js"></script>

    <button onclick="nextStage(<?php echo $_SESSION['code'] ?>)" id="continue-button" disabled>Continue</button>

    <?php if (isset($_GET['startGame'])) { ?>
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
      setInterval(ping, 4000);

    </script>
  </body>
</html>
