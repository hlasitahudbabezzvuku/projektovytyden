<?php
  require $_SERVER["DOCUMENT_ROOT"] . "/utils/database.php";
  global $database;
  $gameCode = $_GET['code'];

  $database->delete("Games", [
    "id" => $gameCode
  ]);

  $database->delete("Players", [
    "game" => $gameCode
  ]);

  $jsonResponse = ["success" => "true"];
  echo json_encode($jsonResponse);

?>