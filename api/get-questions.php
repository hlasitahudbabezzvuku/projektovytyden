<?php
    if (isset($_SESSION) || session_status() !== PHP_SESSION_NONE) {
        session_destroy();
    }

    session_start();
    require $_SERVER["DOCUMENT_ROOT"] . "/utils/database.php";

    $gameCode = $_SESSION["code"];

    $currentStage = $database->get("Games",'stage');
    $typ = "";

    if ($currentStage < 0 || $currentStage > 8) {
        header("Location: http://pubz.infinityfreeapp.com/login.php?failed=" . urlencode("Tvoje hra je v divnem stavu."));
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

    if ($typ = "") {
        header("Location: http://pubz.infinityfreeapp.com/login.php?failed=" . urlencode("Nastala chyba"));
        die();
    }


    $textOtazky = $database->select($typ."Otazky", ["[>]Odpovedi"=>["id_odpovedi" => "id"]], '*');
    
    for ($i = 0; $i < count($textOtazky); $i++) {
        $textOtazky[$i]["id"] = bin2hex($textOtazky[$i]["id"]);
        $textOtazky[$i]["id_odpovedi"] = bin2hex($textOtazky[$i]["id_odpovedi"]);
    }
    $jsonOtazky = json_encode($textOtazky);
    print_r($currentStage);
    print_r($textOtazky);

    exit();
?>