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
        $textOtazky = $database->select($typ."Otazky", ["[>]Odpovedi"=>["id_odpovedi" => "id"]], [$typ, "a", "b", "c", "d"]);

        $jsonOtazky = json_encode($textOtazky);
    }

    exit();
?>