<?php
    require $_SERVER["DOCUMENT_ROOT"] . "/utils/database.php";

    if ($_SERVER["REQUEST_METHOD"] == "GET" || !isset($_POST['code'])) {
        header("Location: http://pubz.infinityfreeapp.com/index.php");
        die();
    }

    $gameCode = $_POST["code"];

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
        case 3:
            $typ = "video";
            break;
        case 5:
            $typ = "zvuk";
            break;
        case 7:
            $typ = "ilustrace";
            break;
    }

    if ($typ != "") {
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["generate"])) {
            $otazky = $database->select("Otazky", ["id"], ["type" => $typ]);
            print_r($otazky);
            $keys = array_rand($otazky, 3);
            print_r($keys);

            $database->delete("GamesOtazky", ["game_id" => $gameCode]);
    
            $order = 0;
            foreach ($keys as $key) {
                echo $key;
                $database->insert("GamesOtazky", [
                    "game_id" => $gameCode,
                    "otazka_id" => $otazky[$key]["id"],
                    "position" => $order,
                ]);
                $order++;
            }
            exit();
        }
    
        if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST["getJSON"])) {
            $otazky = $database->select("GamesOtazky", [
                "[<]Otazky"=>["otazka_id" => "id"], 
                "[<]".$typ."Otazky"=>["Otazky.id"=>"id_otazky"],
                "[<]Odpovedi"=>["Otazky.id_odpovedi"=>"id"]
            ], [
                $typ."Otazky.".$typ, 
                "Odpovedi.a", 
                "Odpovedi.b", 
                "Odpovedi.c", 
                "Odpovedi.d",
                "GamesOtazky.position"
            ], [
                "GamesOtazky.game_id" => $gameCode,
                "ORDER" => ["GamesOtazky.position" => "ASC"]
            ]);
    
            $jsonOtazky = [];

            foreach ($otazky as $otazka) {
                $questionData = [
                    $typ => $otazka[$typ],
                    "odpovedi" => [
                        "a" => $otazka["a"],
                        "b" => $otazka["b"],
                        "c" => $otazka["c"],
                        "d" => $otazka["d"]
                    ],
                    "pozice" => $otazka["position"]
                ];
                $jsonOtazky[] = $questionData; 
            }

            echo json_encode($jsonOtazky);
            exit();
        }
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["getFinished"])) {
      $players = $database->select("Players", "stage_finished", ["game" => $gameCode]);
      $jsonResponse = ["allFinished" => !in_array("0", $players)];
      echo json_encode($jsonResponse);
      exit();
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["finishStage"])) {
      $database->update("Players", [
        "stage_finished" => 1
      ], [
        "id" => hex2bin($_POST["finishStage"])
      ]);
      exit();
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["resetStage"])) {
      $database->update("Players", [
        "stage_finished" => 0
      ], [
        "game" => $gameCode
      ]);
      exit();
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["getFinishedPlayers"])) {
      $players = $database->select("Players", ["name", "score"], [
        "AND" => [
          "game" => $gameCode,
          "stage_finished" => 1
        ]
      ]);
      echo json_encode($players);
      exit();
    }
?>