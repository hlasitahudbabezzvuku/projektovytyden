<?php 
  require $_SERVER["DOCUMENT_ROOT"] . "/utils/database.php";
  global $database;

  $player = $database->select("Players", "*", [
    "id" => hex2bin(urldecode($_GET["player_id"]))
  ]);

  $database->update("LeaderBoard", [
    "name" => $player["name"],
    "core" => $player["score"]
  ]);

  echo json_encode($player);
?>