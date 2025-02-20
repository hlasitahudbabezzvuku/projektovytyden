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

  <!--Join game-->

  <!--<body class="min-h-screen flex items-center justify-center p-4">-->
  <!--  <div class="w-full max-w-lg p-6 fade-in flex flex-col justify-center">-->
  <!--    <a href="index.html" class="arrow-button self-start mb-4">-->
  <!--      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">-->
  <!--        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>-->
  <!--      </svg>-->
  <!--    </a>-->
  <!--    <h2 class="text-2xl font-bold mb-4 text-center">Online Match</h2>-->
  <!--    <label for="onlinePlayerName" class="self-start mb-2">Zadej své jméno</label>-->
  <!--    <input type="text" id="onlinePlayerName" placeholder="Tvé jméno" class="mb-4 p-3 rounded bg-gray-800 text-white placeholder-gray-400 w-full"/>-->
  <!--    <label for="gameCode" class="self-start mb-2">Zadej kód hry</label>-->
  <!--    <input type="text" id="gameCode" placeholder="Kód hry" class="mb-4 p-3 rounded bg-gray-800 text-white placeholder-gray-400 w-full"/>-->
  <!--    <a id="onlineJoinBtn" href="#" class="button w-full">Připojit se</a>-->
  <!--  </div>-->
  <!--</body>-->

  <!--Host game-->

  <!--<body class="min-h-screen flex items-center justify-center p-4">-->
  <!--  <div class="w-full max-w-lg p-6 fade-in flex flex-col justify-center">-->
  <!--    <a href="index.html" class="arrow-button self-start mb-4 inline-block">-->
  <!--      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">-->
  <!--        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>-->
  <!--      </svg>-->
  <!--    </a>-->
  <!--    <h2 class="text-2xl font-bold mb-4 text-center">Vytvořit hru</h2>-->
  <!--    <div class="mb-4">-->
  <!--      <p class="mb-1">Kód hry:</p>-->
  <!--      <span id="gameCodeText" class="font-bold text-xl">ABC123</span>-->
  <!--    </div>-->
  <!--    <div class="mb-4">-->
  <!--      <p class="mb-1">QR kód:</p>-->
  <!--      <img src="https://upload.wikimedia.org/wikipedia/commons/d/d0/QR_code_for_mobile_English_Wikipedia.svg" alt="QR kód" class="w-32 h-auto object-contain bg-white"/>-->
  <!--    </div>-->
  <!--    <div class="mb-4">-->
  <!--      <p class="mb-1">-->
  <!--        Počet připojených hráčů: <span id="playerCount">0</span>-->
  <!--      </p>-->
  <!--    </div>-->
  <!--    <a id="startGameBtn" href="#" class="button w-full">Spustit hru</a>-->
  <!--  </div>-->
  <!--</body>-->

  <!--Join singleplayer-->

  <!--<body class="min-h-screen flex items-center justify-center p-4">-->
  <!--  <div class="w-full max-w-lg p-6 fade-in flex flex-col justify-center">-->
  <!--    <a href="index.html" class="arrow-button self-start mb-4">-->
  <!--      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">-->
  <!--        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>-->
  <!--      </svg>-->
  <!--    </a>-->
  <!--    <h2 class="text-2xl font-bold mb-4 text-center">Singleplayer Mode</h2>-->
  <!--    <label for="playerName" class="self-start mb-2">Zadej své jméno</label>-->
  <!--    <input type="text" id="playerName" placeholder="Tvé jméno" class="mb-4 p-3 rounded bg-gray-800 text-white placeholder-gray-400 w-full"/>-->
  <!--    <a id="joinBtn" href="#" class="button w-full">Spustit hru</a>-->
  <!--  </div>-->
  <!--</body>-->

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

