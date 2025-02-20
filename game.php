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
      <script>getQuestions(<?php echo $_SESSION['code'] ?>)</script>
    <?php } ?>
    <!-- <button onclick="finishStage('<?php echo bin2hex($_SESSION['uuid']); ?>', <?php echo $_SESSION['code'] ?>)"
>Finish</button> -->
      <div id='question'></div>
      <script>printQuestions(<?php echo $_SESSION['code'] ?>)</script>
</body>
</html>