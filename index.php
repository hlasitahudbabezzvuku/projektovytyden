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

    <!-- TODO: make special div -->
    <?php
    if (array_key_exists("failed", $_GET)) {
      echo("<span style=\"color: #ff0000;\">" . $_GET["failed"] . "</span>");
    }
    ?>

    <div class="w-full max-w-5xl flex flex-col md:flex-row items-center justify-center gap-8">
      <div class="w-full md:w-1/2 max-w-lg p-6 fade-in flex flex-col justify-center flex-shrink-0 min-w-[300px] order-2 md:order-1">
        <img src="src/leaderboard.png" alt="Logo" class="self-center md:self-start mb-6 w-full h-auto"/>
        <div class="relative w-full">
          <a id="scrollUp" href="#" class="arrow-button absolute top-0 left-1/2 transform -translate-x-1/2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/>
            </svg>
          </a>
          <div id="leaderboardList" class="space-y-4 overflow-y-auto max-h-60 pt-6 pb-6">
            <div class="leaderboard-item flex justify-between items-center">
              <span class="position">1. Alex</span>
              <span>1500 pts</span>
            </div>
            <div class="leaderboard-item flex justify-between items-center">
              <span class="position">2. Jamie</span>
              <span>1400 pts</span>
            </div>
            <div class="leaderboard-item flex justify-between items-center">
              <span class="position">3. Chris</span>
              <span>1300 pts</span>
            </div>
            <div class="leaderboard-item flex justify-between items-center">
              <span class="position">4. Sam</span>
              <span>1200 pts</span>
            </div>
            <div class="leaderboard-item flex justify-between items-center">
              <span class="position">5. Pat</span>
              <span>1100 pts</span>
            </div>
            <div class="leaderboard-item flex justify-between items-center">
              <span class="position">6. Lee</span>
              <span>1000 pts</span>
            </div>
          </div>
          <a id="scrollDown" href="#" class="arrow-button absolute bottom-0 left-1/2 transform -translate-x-1/2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
          </a>
        </div>
      </div>

      <div class="w-full md:w-1/2 max-w-lg flex flex-col items-center justify-center space-y-4 order-1 md:order-2">
        <div id="gameModeMenu" class="fade-in p-4 w-full flex flex-col items-center justify-center space-y-4">
          <img src="src/ada.png" alt="Logo" class="w-full h-auto object-contain" />
          <div class="w-full flex flex-col items-center gap-4">
            <div class="flex flex-col sm:flex-row items-center gap-4 w-full">
              <a id="singleplayerBtn" href="login.php?mode=single" class="button w-full">
                Singleplayer
              </a>
              <a id="multiplayerBtn" href="#" class="button w-full">
                Multiplayer
              </a>
            </div>
            <div id="extraButtons" class="hidden-buttons flex flex-col gap-3 w-full">
              <a id="localCoopBtn" href="login.php?mode=host" class="button w-full">
                Vytvořit hru
              </a>
              <a id="onlineMatchBtn" href="login.php?mode=join" class="button w-full">
                Připojit se
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <script src="js/script.js"></script>
  </body>
</html>

