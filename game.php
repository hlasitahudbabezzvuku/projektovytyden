<?php
    session_start();
    require $_SERVER["DOCUMENT_ROOT"] . "/utils/database.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <script src="game.js"></script>
    <?php if ($_SERVER["REQUEST_METHOD"] == "GET") { ?>
      <script>getQuestions()</script>
    <?php } ?>
</body>
</html>