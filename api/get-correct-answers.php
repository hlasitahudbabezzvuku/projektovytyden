<?php
  require $_SERVER["DOCUMENT_ROOT"] . "/utils/database.php";
  global $database;

  $answers = json_decode($_GET["answers"]);

  $spravne = $database->select("GamesOtazky", [
    "[>]Otazky" => ["otazka_id" => "id"],
    "[>]Odpovedi" => ["Otazky.id_odpovedi" => "id"]
  ], [
    "spravna"
  ], [
    "game_id" => $_GET["code"],
    "ORDER" => [
      "position" => "ASC"
    ]
  ]);

  $pocetSpravnych = 0;
  $spravne = []

  for ($i = 0; $i < count($answers); $i++) {
    if ($answers[$i] == $spravne[$i]["spravna"]) {
      $pocetSpravnych++;
      $spravne[] = [$i => "correct"];
    } else {
      $spravne[] = [$i => "incorrect"];
    }
  }

  $database->update("Players", [
    "score[+]" => $pocetSpravnych
  ], [
    "id" => hex2bin($_GET["player_id"])
  ]);

  echo json_encode($spravne);
?>