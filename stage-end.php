<?php
  session_start();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
  </head>
  <body>
    <p>Wait for host to start the game</p>
    <script src="game.js"></script>
    <script>

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
      function ping() { fetch('http://pubz.infinityfreeapp.com/api/ping.php')
        .then(function (response) { return response.text(); })
        .then(function (text) { console.log('ping' + text); })};
      setInterval(ping, 5000);
    
    </script>

  </body>
</html>
