<!DOCTYPE html>
<html lang="cz">
  <head>
    <meta charset="UTF-8">
    <title>PubZ</title>
    <?php

    session_start();

    require('Medoo.php');
    require_once 'database.php';
    use Medoo\Medoo;

    if (!array_key_exists('database', $_SESSION)) {
      $_SESSION["database"] = $database;
    }

    ?>
  </head>
  <body>
    Name: <?php echo(htmlspecialchars($_GET["name"])); ?><br>
    Code: <?php echo(htmlspecialchars($_GET["code"])); ?><br>
  </body>
</html>

