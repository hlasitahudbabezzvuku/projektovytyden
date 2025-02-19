<?php
    if (isset($_SESSION) || session_status() !== PHP_SESSION_NONE) {
        session_destroy();
    }

    session_start();
    require $_SERVER["DOCUMENT_ROOT"] . "/utils/database.php";

    $textOtazky = $database->select("textOtazky", ["[>]Odpovedi"=>["id_odpovedi" => "Odpovedi.id"]], ["text", "a", "b", "c", "d", "spravna"]);

    for ($i = 0; $i < count($textOtazky); $i++) {
        $textOtazky[$i]["id"] = bin2hex($textOtazky[$i]["id"]);
        $textOtazky[$i]["id_odpovedi"] = bin2hex($textOtazky[$i]["id_odpovedi"]);
    }
    $jsonOtazky = json_encode($textOtazky);
    print_r($jsonOtazky);
?>
