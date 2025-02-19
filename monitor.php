<?php
    session_start();

    if (array_key_exists("code", $_GET)) {
        $_SESSION['code'] = $_GET["code"];
    } else {
        header("Location: http://pubz.infinityfreeapp.com/index.php?failed=" . urlencode("Prvni musis hru zalozit :("));
    }    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<>
    <script src="game.js"></script>
    <?php if ($_SERVER['REQUEST_METHOD'] == "GET") { ?>
      <script>generateQuestions()</script>
    <?php } ?>
</body>
</html>