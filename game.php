<?php
    session_start();
    require $_SERVER["DOCUMENT_ROOT"] . "/utils/database.php";
?>

<!DOCTYPE html>
<html lang="cs">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>PubZ Multiplayer</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet"/>
    <link href="css/game.css" rel="stylesheet"/>
  </head>
  <body class="min-h-screen flex items-center justify-center p-4 bg-black">
    <div class="w-full max-w-lg p-6 flex flex-col space-y-6">
      <div class="stages fade-in flex items-center justify-center">
        <div class="stage flex items-center">
          <div class="circle border-2 border-yellow-500 bg-yellow-500"></div>
          <div class="connector border-t-2 border-yellow-500"></div>
        </div>
        <div class="stage flex items-center">
          <div class="circle border-2 border-yellow-500"></div>
          <div class="connector border-t-2 border-yellow-500"></div>
        </div>
        <div class="stage flex items-center">
          <div class="circle border-2 border-yellow-500"></div>
          <div class="connector border-t-2 border-yellow-500"></div>
        </div>
        <div class="stage flex items-center">
          <div class="circle border-2 border-yellow-500"></div>
        </div>
      </div>
      
      <!--box s otazkou-->
      <div class="question-box fade-in">Otázka</div>
      
      <!--misto pro media placeholder (text, hudba atd..)-->
      <div class="media-placeholder fade-in bg-gray-800 rounded-lg flex items-center justify-center text-xl text-gray-400 h-72">
        Obsah
      </div>
      
      <!--odpovedi A, B, C, D container-->
      <div class="answers-container fade-in grid grid-cols-2 gap-4">
        <button class="answer-button bg-yellow-500 text-white py-4 w-full rounded-lg hover:bg-yellow-400 transition duration-300 font-bold">
          A) jedna
        </button>
        <button class="answer-button bg-yellow-500 text-white py-4 w-full rounded-lg hover:bg-yellow-400 transition duration-300 font-bold">
          B) dva
        </button>
        <button class="answer-button bg-yellow-500 text-white py-4 w-full rounded-lg hover:bg-yellow-400 transition duration-300 font-bold">
          C) tři
        </button>
        <button class="answer-button bg-yellow-500 text-white py-4 w-full rounded-lg hover:bg-yellow-400 transition duration-300 font-bold">
          D) čtyři
        </button>
      </div>
    </div>

    <script src="game.js"></script>
    <script>
      document.addEventListener('DOMContentLoaded', () => {
        document
          .querySelectorAll('.fade-in')
          .forEach((el) => el.classList.add('show'))
        loadQuestion(<?php echo $_SESSION['code'] ?>, '<?php echo bin2hex($_SESSION['uuid']); ?>', '<?php echo $_SERVER["DOCUMENT_ROOT"];?>')
      })

      // frantovo - nesahat!
      function ping() { fetch('http://pubz.infinityfreeapp.com/api/ping-player.php')
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

