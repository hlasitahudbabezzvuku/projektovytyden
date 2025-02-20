<?php
  require $_SERVER["DOCUMENT_ROOT"] . "/utils/database.php";
  global $database;

  $gameCode = $_GET["code"];

  $currentStage = $database->get("Games", 'stage', [
    "id" => $gameCode
  ]);
  $typ = "";

  if ($currentStage < 0 || $currentStage > 8) {
    header("Location: http://pubz.infinityfreeapp.com/index.php?failed=" . urlencode("Tvoje hra je v divnem stavu."));
    die();
  }

  switch ($currentStage) {
    case 1:
        $typ = "text";
        break;
    case 2: case 3:
        $typ = "video";
        break;
    case 4: case 5:
        $typ = "zvuk";
        break;
    case 6: case 7:
        $typ = "ilustrace";
        break;
  }

  $otazky = $database->select("Otazky", ["id"], ["type" => $typ]);
  $keys = array_rand($otazky, 3);

  $database->delete("GamesOtazky", ["game_id" => $gameCode]);

  $order = 0;
  foreach ($keys as $key) {
    $database->insert("GamesOtazky", [
      "game_id" => $gameCode,
      "otazka_id" => $otazky[$key]["id"],
      "position" => $order,
    ]);
    $order++;
  }
?>