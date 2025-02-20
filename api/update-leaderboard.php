<?php 
  require $_SERVER["DOCUMENT_ROOT"] . "/utils/database.php";
  global $database;

  $player = $database->select("Players", ["name", "score"], [
    "id" => hex2bin(urldecode($_GET["player_id"]))
  ]);

  $database->insert("LeaderBoard", [
    "name" => $player[0]["name"],
    "score" => $player[0]["score"]
  ]);

  echo print_r($player);
?>