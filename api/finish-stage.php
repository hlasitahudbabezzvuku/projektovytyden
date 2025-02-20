<?php
  require $_SERVER["DOCUMENT_ROOT"] . "/utils/database.php";
  global $database;


  $database->update("Players", [
    "stage_finished" => 1
  ], [
    "id" => hex2bin($_GET["player_id"])
  ]);

  echo json_encode($_GET['answers'])
?>