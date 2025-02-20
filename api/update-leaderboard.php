<?php 
  require $_SERVER["DOCUMENT_ROOT"] . "/utils/database.php";
  global $database;

  $player = $database->select("Players", ["name", "score"], [
    "id" => hex2bin($_GET["player_id"])
  ]);

  $database->update("LeaderBoard", [
    "name" => $player[0]["name"],
    "core" => $player[0]["score"]
  ]);

  echo print_r($player);
?>