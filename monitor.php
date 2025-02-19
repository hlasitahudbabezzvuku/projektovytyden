<?php
  require $_SERVER["DOCUMENT_ROOT"] . "/utils/database.php";
  session_start();

  if (array_key_exists("id", $_GET)) {
    $_SESSION['code'] = $_GET["id"];
  } else {
    header("Location: http://pubz.infinityfreeapp.com/index.php?failed=" . urlencode("Prvni musis hru zalozit :("));
  } 

  function deleteGame() {
    global $database;
    $gameCode = $_SESSION['code'];

    $database->delete("Games", [
      "id" => $gameCode
    ]);

    $database->delete("Players", [
      "game" => $gameCode
    ]);
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
  <script src="game.js"></script>
    <button onclick="resetStage(<?php echo $_SESSION['code']; ?>)" id="continue-button" disabled>Continue</button>
  <?php if ($_SERVER['REQUEST_METHOD'] == "GET") {?>
    <script>generateQuestions(<?php echo $_SESSION['code']; ?>)</script>
  <?php } ?>
  <script>let gameInterval = setInterval(getFinished, 2000, <?php echo $_SESSION["code"] ?>)</script>
</body>
</html>