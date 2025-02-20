<?php
    session_start();
    require $_SERVER["DOCUMENT_ROOT"] . "/utils/database.php";
?>

<!DOCTYPE html>
<html lang="cs">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Kvíz Hra Multiplayer</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.plyr.io/3.6.8/plyr.js"></script>
    <link
      href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap"
      rel="stylesheet"
    />
    <style>
body {
  font-family: 'Montserrat', sans-serif;
  margin: 0;
  height: 100vh;
  display: flex;
  justify-content: center;
  align-items: flex-start;
}

.w-full {
  display: flex;
  flex-direction: column;
  justify-content: flex-start;
  height: 100%;
}

.fade-in {
  opacity: 0;
  transform: translateY(20px);
  transition: opacity 0.8s, transform 0.8s;
}
.fade-in.show {
  opacity: 1;
  transform: translateY(0);
}

.question-box {
  background: rgba(32, 32, 32, 0.6);
  backdrop-filter: blur(8px);
  border-radius: 1rem;
  padding: 2rem;
  font-size: 2rem;
  font-weight: 700;
  color: #ffffff;
  text-align: center;
  margin-top: 0;
}

.circle {
  width: 2rem;
  height: 2rem;
  border-radius: 9999px;
  background-color: transparent;
  transition: background-color 0.3s, transform 0.3s;
}
.connector {
  width: 1.5rem;
}

.stages {
  padding-bottom: 6rem;
}

.answer-button {
  background-color: #fbbf24;
  color: white;
  padding: 1rem;
  width: 100%;
  border-radius: 0.5rem;
  font-weight: bold;
  font-size: 1.2rem;
  transition: background-color 0.3s, transform 0.3s;
  display: flex;
  justify-content: center;
  align-items: center;
  text-align: center;
}

.answer-button:hover {
  background-color: #f59e0b;
}

/* Media Queries */
@media (max-width: 450px) {
  .question-box {
    font-size: 1.2rem;
    padding: 1.5rem;
  }

  .answer-button {
    font-size: 1rem; 
    padding: 0.8rem;
  }
}

@media (max-width: 640px) {
  .question-box {
    font-size: 1.5rem;
    padding: 1.5rem;
  }

  .answers-container {
    grid-template-columns: 1fr;
  }

  .answer-button {
    font-size: 1rem;
    padding: 0.8rem;
  }
  
  .stages {
    padding-bottom: 3rem;
  }
}

/* Make the play/pause button larger */
.plyr__control {
  font-size: 4rem; /* Make the button larger */
  width: 80px; /* Larger width */
  height: 80px; /* Larger height */
}

/* Adjust the size of the SVG icon inside the play/pause button */
.plyr__control svg {
  width: 100%; /* Make the icon fill the button */
  height: 100%; /* Make the icon fill the button */
}

/* Position the play/pause button in the center */
.plyr__controls {
  position: relative; /* Ensure controls are positioned relative to parent */
}

.plyr__controls__item[data-plyr="play"] {
  position: absolute; /* Make button position absolute */
  top: 50%; /* Center vertically */
  left: 50%; /* Center horizontally */
  transform: translate(-50%, -50%); /* Center the button perfectly */
  z-index: 10; /* Make sure it stays on top */
}
/* Or customize the size of the Plyr player wrapper directly */
.plyr {
  width: 100%; /* Make the player container fill the width of its parent */
  height: 100%; /* Make the player container fill the height of its parent */
}

/* Example: Adjust both width and height with a fixed value */
.plyr__video-wrapper {
  width: 100%; /* Ensure video wrapper takes the full width */
  height: 100%; /* Ensure video wrapper takes the full height */
}


@media (min-width: 1024px) {
  .question-box {
    font-size: 2.5rem; 
    padding: 2rem;
  }

  .answers-container {
    grid-template-columns: 1fr 1fr;
    gap: 2rem;
  }

  .answer-button {
    font-size: 1.2rem;
    padding: 1.2rem;
  }

  .stages {
    padding-bottom: 6rem;
  }
}
    </style>
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
      <div
        class="media-placeholder fade-in bg-gray-800 rounded-lg flex items-center justify-center text-xl text-gray-400 h-72"
      >
        Obsah
      </div>
      
      <!--odpovedi A, B, C, D container-->
      <div class="answers-container fade-in grid grid-cols-2 gap-4">
        <button
          class="answer-button bg-yellow-500 text-white py-4 w-full rounded-lg hover:bg-yellow-400 transition duration-300 font-bold"
        >
          A) jedna
        </button>
        <button
          class="answer-button bg-yellow-500 text-white py-4 w-full rounded-lg hover:bg-yellow-400 transition duration-300 font-bold"
        >
          B) dva
        </button>
        <button
          class="answer-button bg-yellow-500 text-white py-4 w-full rounded-lg hover:bg-yellow-400 transition duration-300 font-bold"
        >
          C) tři
        </button>
        <button
          class="answer-button bg-yellow-500 text-white py-4 w-full rounded-lg hover:bg-yellow-400 transition duration-300 font-bold"
        >
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
        loadQuestion(<?php echo $_SESSION['code'] ?>, '<?php echo bin2hex($_SESSION['uuid']); ?>')
      })

      // frantovo - nesahat!
      function ping() { fetch('http://pubz.infinityfreeapp.com/api/ping-player.php')
        .then(function (response) { return response.text(); })
        .then(function (text) { console.log('ping' + text); })};
      setInterval(ping, 5000);

    </script>
  </body>
</html>

<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <script src="game.js"></>
    <button onclick="finishStage('<?php echo bin2hex($_SESSION['uuid']); ?>')"
>Finish</button>
      <div id='question'></div>
</body>
</html> -->

<!-- **KOD PRO STRANKU S MULTIPLAYER MODEM (otazky)** -->
