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
    <title>PubZ</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <link href="css/index.css" rel="stylesheet"/>
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

    <div class="w-full max-w-5xl flex flex-col md:flex-row items-center justify-center gap-8">
      <div class="w-full md:w-1/2 max-w-lg p-6 fade-in flex flex-col justify-center flex-shrink-0 min-w-[300px] order-2 md:order-1">
        <img src="src/leaderboard.png" alt="Logo" class="self-center md:self-start -6 w-full h-auto"/>
        <div class="relative w-full">
          <div id="leaderboardList" class="space-y-4 overflow-y-auto max-h-60 pt-6 pb-6">

            <?php

            $data = $database->select("LeaderBoard", [ "name", "score" ], [ "ORDER" => [ "score" => "DESC" ] ]);

            foreach($data as $item) {

            ?>

            <div class="leaderboard-item flex justify-between items-center">
              <span class="position"><?php echo $item["name"]; ?></span>
              <span><?php echo $item["score"]; ?> bodů</span>
            </div>
            
            <?php } ?>

          </div>
          <div class="absolute bottom-0 left-0 w-full h-12 pointer-events-none bg-gradient-to-t from-[#080808] to-transparent"></div>
          <a id="scrollDown" href="#" class="arrow-button absolute bottom-0 left-1/2 transform -translate-x-1/2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
          </a>
        </div>
      </div>

      <div class="w-full md:w-1/2 max-w-lg flex flex-col items-center justify-center space-y-4 order-1 md:order-2">
        <div id="gameModeMenu" class="fade-in p-4 w-full flex flex-col items-center justify-center space-y-4">
          <img src="src/ada.png" alt="Logo" class="blikani w-full h-auto object-contain" />
          <div class="w-full flex flex-col items-center gap-4">
            <div class="flex flex-col sm:flex-row items-center gap-4 w-full">
              <a id="singleplayerBtn" href="index.php?failed=<?php echo urlencode('Podekujte hostingu InfinityFree za to ze tenhle podelanej mod nefunguje protoze nam ve 4 rano zablokovali nasi domenu takze jsem to do 5ti do rana musel presouvat cely projek na muj pocitac ktery ted slouzi jako server >:(') ?>" class="button w-full">
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

    <script>if (localStorage.getItem('answers')) localStorage.removeItem('answers')</script>

    <script src="js/script.js"></script>
  </body>
</html>

