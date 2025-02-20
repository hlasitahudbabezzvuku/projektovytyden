<?php
    require $_SERVER["DOCUMENT_ROOT"] . "/utils/database.php";

    $gameCode = $_GET["code"];

    $currentStage = $database->get("Games", 'stage', [
        "id" => $gameCode
    ]);
    $typ = "";
    // echo "ahoj";

    if ($currentStage < 0 || $currentStage > 8) {
        header("Location: http://pubz.infinityfreeapp.com/index.php?failed=" . urlencode("Tvoje hra je v divnem stavu."));
        die();
    }

    switch ($currentStage) {
        case 1:
            $typ = "text";
            break;
        case 3:
            $typ = "zvuk";
            break;
        case 5:
            $typ = "video";
            break;
        case 7:
            $typ = "ilustrace";
            break;
    }

    echo $typ;

    if ($typ != "") {    
      try {
        // Your query here
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
    } catch (Exception $e) {
        echo "SQL Error: " . $e->getMessage();
        exit;
    }
    

      echo json_encode($otazky);

      $jsonOtazky = [];

      foreach ($otazky as $otazka) {
          $questionData = [
              "otazka" => $otazka[$typ],
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

      // print_r(json_encode($otazky));
      // echo json_encode($jsonOtazky);
    }
?>