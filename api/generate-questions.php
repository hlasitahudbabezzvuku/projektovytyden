<?php
  require $_SERVER["DOCUMENT_ROOT"] . "/utils/database.php";
  global $database;

    $otazky = $database->select("Otazky", ["id"], ["type" => $typ]);
    print_r($otazky);
    $keys = array_rand($otazky, 3);
    print_r($keys);

    $database->delete("GamesOtazky", ["game_id" => $gameCode]);

    $order = 0;
    foreach ($keys as $key) {
        $database->insert("GamesOtazky", [
            "game_id" => $_GET['code'],
            "otazka_id" => $otazky[$key]["id"],
            "position" => $order,
        ]);
        $order++;
      }
    exit();
?>