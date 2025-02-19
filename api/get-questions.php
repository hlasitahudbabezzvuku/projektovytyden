<?php
    session_start();
    require $_SERVER["DOCUMENT_ROOT"] . "/utils/database.php";

    $gameCode = $_SESSION["code"];

    $currentStage = $database->get("Games", "stage", [
        "id" => $gameCode
    ]);
    echo $currentStage;
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
    echo $typ;

    if ($typ != "") {
        $otazky = $database->select("Otazky", ["[>]Odpovedi"=>["id_odpovedi" => "id"], "[>]".$typ."Otazky"=>["id"=>"id_otazky"]], [$typ, "a", "b", "c", "d"]);

        $randomOtazky = array_rand($diceNumbers, 3);
        print_r($randomOtazky);

        $jsonOtazky = json_encode($otazky);
        echo "{";
        
        foreach ($otazky as $otazka) {
            echo "'".$typ."': ".$otazka[$typ].",";
            echo "odpovedi: {";
            echo "'a': ".$otazka["a"].",";
            echo "'b': ".$otazka["b"].",";
            echo "'c': ".$otazka["c"].",";
            echo "'d': ".$otazka["d"].",";
            echo "}";
        }
        echo "}";
        // print_r($jsonOtazky);
    }

    exit();
?>