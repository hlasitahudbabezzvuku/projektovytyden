<?php
  require $_SERVER["DOCUMENT_ROOT"] . "/utils/database.php";
  session_start();

  if (array_key_exists("id", $_GET)) {
      $_SESSION['code'] = $_GET["id"];
      $gameCode = $_SESSION['code'];
  } else {
      header("Location: http://pubz.infinityfreeapp.com/index.php?failed=" . urlencode("Prvni musis hru zalozit :("));
  } 

  function deleteGame() {
    global $database, $gameCode;

    $database->delete("Games", [
      "id" => $gameCode
    ]);
  }
  
  function addStage() {
    global $database, $gameCode;
    $currentStage = $database->get("Games", 'stage', [
      "id" => $gameCode
    ]);

    if ($currentStage == 8) {
      deleteGame();
    }

    if ($currentStage < 0 || $currentStage > 8) {
      header("Location: http://pubz.infinityfreeapp.com/index.php?failed=" . urlencode("Tvoje hra je v divnem stavu."));
      die();
    }
    
    $database->update("Games", ['stage[+]' => 1], ["id" => $gameCode]);
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
  <?php if ($_SERVER['REQUEST_METHOD'] == "GET") { addStage();?>
    <script>generateQuestions(<?php echo $_SESSION['code']; ?>)</script>
  <?php } ?>
</body>
</html>