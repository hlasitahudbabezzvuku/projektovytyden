<?php
  require $_SERVER["DOCUMENT_ROOT"] . "/utils/database.php";
  global $database;

  $gameCode = $_GET["code"];

  $players = $database->select("Players", ["name", "score"], [
    "AND" => [
      "game" => $gameCode,
      "stage_finished" => 1
    ]
  ]);
  echo json_encode($players);
  exit();
?>