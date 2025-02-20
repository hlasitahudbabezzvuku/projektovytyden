<?php
  require $_SERVER["DOCUMENT_ROOT"] . "/utils/database.php";
  global $database;

  $answers = json_decode($_GET["answers"]);

  $database->update("Players", [
    "stage_finished" => 1
  ], [
    "id" => hex2bin($_GET["player_id"])
  ]);

  $spravne = $databse->select("GamesOtazky", [
    "[>]Otazky" => ["otazka_id" => "id"],
    "[>]Odpovedi" => ["Otazky.id" => "id"]
  ], [
    "spravna"
  ], [
    "game" => $_GET["code"]
  ]);

  $pocetSpravnych = 0;

  for ($i = 0; $i < count($answers); $i++) {
    if ($answers[$i] == $spravne[$i]) {
      $pocetSpravnych++;
    }
  }

  $database->update("Players", [
    "score" => $pocetSpravnych
  ], [
    "id" => hex2bin($_GET["player_id"])
  ]);

  $jsonResponse = ["spravne" => $pocetSpravnych];
  echo json_encode($jsonResponse);
?>