<?php
  session_start();
?>

<!DOCTYPE html>
<html lang="cs">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Výsledky kategorie</title>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;600;700&display=swap" rel="stylesheet" />
  <style>
    body {
      background-color: #000;
      color: #fff;
      font-family: 'Montserrat', sans-serif;
      font-weight: 300;
      line-height: 1.6;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
      padding: 1rem;
      margin: 0;
    }

    .logo {
      position: absolute;
      top: 1rem;
      left: 1rem;
    }
    .logo img {
      width: 150px;
      animation: blink 3s linear infinite;
    }

    @keyframes blink {
      0% { opacity: 1; }
      50% { opacity: 0.5; }
      100% { opacity: 1; }
    }

    .container {
      background-color: #1a1a1a;
      border-radius: 0.5rem;
      padding: 1.5rem;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
      width: 100%;
      max-width: 400px;
      opacity: 0;
      transform: translateY(20px);
      transition: opacity 0.8s, transform 0.8s;
    }
    .container.show {
      opacity: 1;
      transform: translateY(0);
    }

    h1 {
      color: #fff;
      font-size: 2rem;
      font-weight: 600;
      text-align: center;
      margin: 1rem 0;
    }

    p {
      font-size: 1.125rem;
      opacity: 0.8;
      text-align: center;
      margin-bottom: 1rem;
    }

    .results-list {
      text-align: left;
      margin: 1.5rem auto;
      font-size: 1.125rem;
      max-width: 350px;
    }
    .results-list li {
      padding: 0.5rem 1rem;
      border-bottom: 1px solid #444444;
      transition: background-color 0.3s;
    }
    .results-list span.correct {
      color: #00ff00;
    }
    .results-list span.incorrect {
      color: #ff3333;
    }
    .results-list li:last-child {
      border-bottom: none;
    }

    .waiting-msg {
      margin-top: 2rem;
      font-size: 1.25rem;
      font-weight: 700;
      color: #e7a635;
      text-align: center;
    }

    @media (max-width: 450px) {
      body {
        justify-content: flex-start;
        padding-top: 2rem;
      }
      .container {
        padding: 1rem;
        max-width: 250px;
      }
      h1 {
        font-size: 1.4rem;
      }
      p, .results-list li, .waiting-msg {
        font-size: 0.9rem;
      }
      .logo {
        position: static;
        display: flex;
        justify-content: center;
        margin-bottom: 3rem;
        padding-top: 1rem;
      }
      .logo img {
        width: 100px;
      }
    }

    @media (max-width: 640px) {
      .container {
        padding: 1rem;
      }
      .logo img {
        width: 150px;
      }
    }

    @media (min-width: 1024px) {
      .container {
        padding: 1.5rem;
        max-width: 600px;
      }
      h1 {
        font-size: 2.2rem;
      }
      .results-list li, .waiting-msg {
        font-size: 1.2rem;
      }
      .logo img {
        width: 180px;
      }
    }
  </style>
</head>
<body>
  <div class="logo">
    <a href="index.html">
      <img src="src/ada.png" alt="PUBS logo"/>
    </a>
  </div>
  <div class="container show">
    <h1>Výsledky kategorie</h1>
    <p>Zde vidíte, které odpovědi jste zodpověděli správně:</p>
    <ul class="results-list" id="results-list">
      <!--ZDE PHP KOD => dynamicke vkladani li-->
      <!--udelal jsem tady spany, aby obarvily text pro lepsi citelnost => spravne/spatne;;; muzete pomoci boolu v databazi(spravne/spatne) menit ten html kod => jestli se napise span s classou correct, nebo incorrect (PAJA:D)-->
      <li>Otázka 1: <span class="correct">Správně</span></li>
      <li>Otázka 2: <span class="incorrect">Špatně</span></li>
      <li>Otázka 3: <span class="correct">Správně</span></li>
      <li>Otázka 4: <span class="correct">Správně</span></li>
      <li>Otázka 5:  <span class="incorrect">Špatně</span></li>
      <li>Otázka 6: <span class="correct">Správně</span></li>
    </ul>
    <div class="waiting-msg">
      Čeká se na hostitele, který potvrdí přechod do další kategorie...
    </div>
  </div>
  <script src="game.js"></script>
  <script>
    getResult('<?php echo bin2hex($_SESSION["uuid"]);?>', <?php echo $_SESSION['code']; ?>);
    setInterval(() => {
      fetch('http://pubz.infinityfreeapp.com/api/player-finished.php?uuid=' + '<?php echo urlencode(bin2hex($_SESSION["uuid"])) ?>')
        .then(function (response) { return response.text(); })
        .then(function (text) {
          console.log(text);
          if (text === '0') {
            window.location.replace('http://pubz.infinityfreeapp.com/game.php');
          } 
        });
    }, 2000)
    
      // frantovo - nesahat!
      function ping() { fetch('http://pubz.infinityfreeapp.com/api/ping-player.php')
        .then(function (response) { return response.text(); })
        .then(function (text) {
          if (text.length == 1)
            console.log("Ping: OK");
          else
            window.location.replace(encodeURI("http://pubz.infinityfreeapp.com/index.php?failed=" + text));
        })};
      setInterval(ping, 5000);
    
    </script>
</body>
</html>
