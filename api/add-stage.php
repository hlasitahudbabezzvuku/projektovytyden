<?php
  require $_SERVER["DOCUMENT_ROOT"] . "/utils/database.php";
  global $database;
  $gameCode = $_GET['code'];

  $currentStage = $database->get("Games", 'stage', [
    "id" => $gameCode
  ]);

  if ($currentStage == 8) {
    header("Location: https://pubz.infinityfreeapp.com/index.php?delete_game="+$gameCode);
    die();
  }

  if ($currentStage < 0 || $currentStage > 8) {
    header("Location: https://pubz.infinityfreeapp.com/index.php?failed=" . urlencode("Tvoje hra je v divnem stavu."));
    die();
  }
  
  $database->update("Games", ['stage[+]' => 1], ["id" => $gameCode]);

  $json_response = ["success" => "true"];
  echo json_encode($json_response);
?>