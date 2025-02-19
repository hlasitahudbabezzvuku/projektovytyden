<?php
  require $_SERVER["DOCUMENT_ROOT"] . "/utils/database.php";
  global $database;

  $gameCode = $_GET['code'];

  $players = $database->select("Players", "stage_finished", ["game" => $gameCode]);
  $jsonResponse = ["allFinished" => !in_array("0", $players)];
  echo json_encode($jsonResponse);
  exit();
?>