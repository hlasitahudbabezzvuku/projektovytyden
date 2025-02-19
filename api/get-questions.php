<?php
    session_start();
    require $_SERVER["DOCUMENT_ROOT"] . "/utils/database.php";

    $gameCode = $_SESSION["code"];
    echo $gameCode;

    $currentStage = $database->get("Games", 'stage', [
        "id" => $gameCode
    ]);
    print_r($currentStage);
    $typ = "";

    // if ($currentStage < 0 || $currentStage > 8) {
    //     header("Location: http://pubz.infinityfreeapp.com/index.php?failed=" . urlencode("Tvoje hra je v divnem stavu."));
    //     die();
    // }

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
        $otazky = $database->select("GamesOtazky", [
            "[<]Otazky"=>["otazka_id" => "id"], 
            "[<]".$typ."Otazky"=>["Otazky.id"=>"id_otazky"],
            "[<]Odpovedi"=>["Otazky.id"=>"id"]], [$typ."Otazky.".$typ, "Odpovedi.a", "Odpovedi.b", "Odpovedi.c", "Odpovedi.d"], ["GamesOtazky.game_id" => $gameCode]);
        // $otazky = $database->select("Otazky", ["id"], ["type" => $typ]);
        print_r($otazky);
        // $keys = array_rand($otazky, 3);
        // print_r($keys);

        // $order = 0;
        // foreach ($keys as $key) {
        //     echo $key;
        //     $database->insert("GamesOtazky", [
        //         "game_id" => $gameCode,
        //         "otazka_id" => $otazky[$key]["id"],
        //         "position" => $order,
        //     ]);
        //     $order++;
        // }
        

        $jsonOtazky = json_encode($otazky);
        // echo "{";
        
        // foreach ($otazky as $otazka) {
        //     echo "'".$typ."': ".$otazka[$typ].",";
        //     echo "odpovedi: {";
        //     echo "'a': ".$otazka["a"].",";
        //     echo "'b': ".$otazka["b"].",";
        //     echo "'c': ".$otazka["c"].",";
        //     echo "'d': ".$otazka["d"].",";
        //     echo "}";
        // }
        // echo "}";
        // print_r($jsonOtazky);
    }

    exit();
?>