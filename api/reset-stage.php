<?php 
  require $_SERVER["DOCUMENT_ROOT"] . "/utils/database.php";
  global $database;

  $gameCode = $_GET['code'];

  $database->update("Players", [
    "stage_finished" => 0
  ], [
    "game" => $gameCode
  ]);
  $jsonResponse = ["success" => "true"];
  echo json_encode($jsonResponse);
  exit();
?>