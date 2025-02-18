<!DOCTYPE html>
<html lang="cz">
  <head>
    <meta charset="UTF-8">
    <title>PubZ</title>
    <?php
      session_start();
      require('database.php');
    ?>
  </head>
  <body>
    Name: <?php echo(htmlspecialchars($_GET["name"])); ?><br>
    Code: <?php echo(htmlspecialchars($_GET["code"])); ?><br>
  </body>
</html>

