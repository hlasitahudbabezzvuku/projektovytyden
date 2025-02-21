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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <link href="css/index.css" rel="stylesheet" />
    <title>PubZ</title>
  </head>

  <body class="min-h-screen flex items-center justify-center p-4">

    <?php if (array_key_exists("failed", $_GET)) { ?>

      <div class="fixed transform -translate-x-1/2 -translate-y-1/2 z-50 w-full max-w-lg p-6 fade-in flex flex-col justify-center bg-red-100 border border-red-400 text-red-700 rounded" role="alert">
        <span class="block sm:inline"><?php echo($_GET["failed"]); ?></span>
        <span onclick="this.parentNode.style.display = 'none';" class="absolute top-0 right-0 px-4 py-3">
          <svg class="fill-current h-6 w-6 text-red-500" role="button" viewBox="0 0 20 20">
            <title>Zavřít</title>
            <path d="M14.348 5.652a1 1 0 00-1.414 0L10 8.586 7.066 5.652a1 1 0 10-1.414 1.414L8.586 10l-2.934 2.934a1 1 0 101.414 1.414L10 11.414l2.934 2.934a1 1 0 001.414-1.414L11.414 10l2.934-2.934a1 1 0 000-1.414z"/>
          </svg>
        </span>
      </div>

    <?php } ?>

    <div class="w-full max-w-lg p-6 fade-in flex flex-col justify-center">
      <a href="index.php" class="arrow-button self-start mb-4 inline-block">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
      </a>

      <!--Join game w. game-->
      <?php if (array_key_exists("game", $_GET)) { ?>

        <form action="connect.php" method="GET">
          <h2 class="text-2xl font-bold mb-4 text-center">Online Hra</h2>
          <label for="onlinePlayerName" class="self-start mb-2">Zadej své jméno</label>
          <input name="name" type="text" id="onlinePlayerName" placeholder="Tvé jméno" class="mb-4 p-3 rounded bg-gray-800 text-white placeholder-gray-400 w-full"/>
          <input type="hidden" name="code" value="<?php echo htmlspecialchars($_GET['game']); ?>">
          <input type="submit" id="onlineJoinBtn" class="button w-full" value="Připojit se">
        </form>

      <!--Host game-->
      <?php } elseif (array_key_exists("mode", $_GET) && $_GET["mode"] == "host") { ?>

        <?php

        session_start();

        function GenerateCode() {
          global $database;
          $code = rand(100000, 999999);
          if (!empty($database->get("Games", "id", [ "id" => $code ]))) {
            return GenerateCode();
          } else {
            return $code;
          }
        }

        $code = GenerateCode();
        global $code;

        $database->insert("Games", [
          "id" => $code,
          "last_ping" => time()
        ]);

        $_SESSION["code"] = $code;

        ?>

        <h2 class="text-2xl font-bold mb-4 text-center text-white">Vytvořit hru</h2>
        <div class="mb-4">
          <p class="mb-1 text-white">Kód hry:</p>
          <span id="gameCodeText" class="font-bold text-xl text-white"><?php echo $code ?></span>
        </div>
        <div class="mb-4">
          <p class="mb-1 text-white">QR kód:</p>
          <img src="https://api.qrserver.com/v1/create-qr-code/?data=<?php echo urlencode('https://pubz.l3dnac3k.net/login.php?game=' . $code) ?>" alt="QR kód" class="w-3/4 h-auto object-contain bg-white p-1 rounded"/>
        </div>
        <div class="mb-4">
          <p class="mb-1 text-white">Připojeni hráči</p>
          <ul id="playerList" class="space-y-2">
          </ul>
        </div>

        <form action="monitor.php" method="GET">
          <input type="hidden" name='id' value=<?php echo $code ?>>
          <input type="hidden" name='startGame' value='true'>
          <input type="submit" id="startGameBtn"  class="button w-full" value="Spustit hru">
        </form>

        <script>

          function get_players() { fetch('https://pubz.l3dnac3k.net/api/get-players.php?game=' + <?php echo $code ?>)
            .then(function (response) { return response.text(); })
            .then(function (text) { document.getElementById('playerList').innerHTML = text; }); };
          setInterval(get_players, 2000);

          function ping() { fetch('https://pubz.l3dnac3k.net/api/ping-game.php')
            .then(function (response) { return response.text(); })
            .then(function (text) {
              if (text.length == 1)
                console.log("Ping: OK");
              else
                window.location.replace(encodeURI("https://pubz.l3dnac3k.net/index.php?failed=" + text));
            })};
          setInterval(ping, 5000);

        </script>

      <!--Join singleplayer-->
      <?php } elseif (array_key_exists("mode", $_GET) && $_GET["mode"] == "single") { ?>


      <form action="connect.php" method="GET">
        <h2 class="text-2xl font-bold mb-4 text-center">Hra jednoho hráče</h2>
        <label for="playerName" class="self-start mb-2">Zadej své jméno</label>
        <input type="text" name="name" id="playerName" placeholder="Tvé jméno" class="mb-4 p-3 rounded bg-gray-800 text-white placeholder-gray-400 w-full"/>
        <input type="submit" id="joinBtn" class="button w-full" value="Spustit hru">
      </form>

      <!--Join game-->
      <?php } else { ?>

        <form action="connect.php" method="GET">
          <h2 class="text-2xl font-bold mb-4 text-center">Online Hra</h2>
          <label for="onlinePlayerName" class="self-start mb-2">Zadej své jméno</label>
          <input name="name" type="text" id="onlinePlayerName" placeholder="Tvé jméno" class="mb-4 p-3 rounded bg-gray-800 text-white placeholder-gray-400 w-full"/>
          <label for="gameCode" class="self-start mb-2">Zadej kód hry</label>
          <input name="code" type="text" id="gameCode" placeholder="Kód hry" class="mb-4 p-3 rounded bg-gray-800 text-white placeholder-gray-400 w-full"/>
          <input type="submit" id="onlineJoinBtn" class="button w-full" value="Připojit se">
        </form>

      <?php } ?>
    </div>
  </body>
</html>

