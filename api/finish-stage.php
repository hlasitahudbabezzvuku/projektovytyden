<?php
  require $_SERVER["DOCUMENT_ROOT"] . "/utils/database.php";
  global $database;

  $database->update("Players", [
    "stage_finished" => 1
  ], [
    "id" => hex2bin($_GET["player_id"])
  ]);

  $jsonResponse = ["success" => "true"];
  echo json_encode($jsonResponse);
?>