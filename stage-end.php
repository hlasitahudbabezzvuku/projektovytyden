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
  <link href="css/stage-end.css" rel="stylesheet"/>
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
      <!-- <li>Otázka 1: <span class="correct">Správně</span></li>
      <li>Otázka 2: <span class="incorrect">Špatně</span></li>
      <li>Otázka 3: <span class="correct">Správně</span></li>
      <li>Otázka 4: <span class="correct">Správně</span></li>
      <li>Otázka 5:  <span class="incorrect">Špatně</span></li>
      <li>Otázka 6: <span class="correct">Správně</span></li> -->
    </ul>
    <div class="waiting-msg">
      Čeká se na hostitele, který potvrdí přechod do další kategorie...
    </div>
  </div>
  <script src="game.js"></script>
  <script>

    getResult('<?php echo bin2hex($_SESSION["uuid"]);?>', <?php echo $_SESSION['code']; ?>);
    setInterval(() => {
      await fetch('https://pubz.l3dnac3k.net/api/get-stage.php?game=' + '<?php echo $_SESSION["code"]; ?>')
        .then(function (response) { return response.text(); })
        .then(function (text) {
          console.log(text);
          if (text === '9') {
            localStorage.removeItem('result')
            window.location.replace('https://pubz.l3dnac3k.net/end.php');
          } 
      });
      fetch('https://pubz.l3dnac3k.net/api/player-finished.php?uuid=' + '<?php echo urlencode(bin2hex($_SESSION["uuid"])) ?>')
        .then(function (response) { return response.text(); })
        .then(function (text) {
          console.log(text);
          if (text === '0') {
            localStorage.removeItem('result')
            window.location.replace('https://pubz.l3dnac3k.net/game.php');
          } 
        });
    }, 2000)
    
    // frantovo - nesahat!
    function ping() { fetch('https://pubz.l3dnac3k.net/api/ping-player.php')
      .then(function (response) { return response.text(); })
      .then(function (text) {
        if (text.length == 1)
          console.log("Ping: OK");
        else
          window.location.replace(encodeURI("https://pubz.l3dnac3k.net/index.php?failed=" + text));
      })};
    setInterval(ping, 4000);
    
    </script>
</body>
</html>
