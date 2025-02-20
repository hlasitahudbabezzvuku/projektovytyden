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
    <button onclick="finishStage('<?php echo bin2hex($_SESSION['uuid']); ?>')"
>Finish</button>
      <div id='question'></div>
      <div id='score-board'></div>
      <script>printQuestions(<?php echo $_SESSION['code'] ?>, '<?php echo bin2hex($_SESSION['uuid']); ?>')</script>
</body>
</html>