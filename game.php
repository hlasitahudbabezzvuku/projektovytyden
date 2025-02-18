<?php
    if (isset($_SESSION) || session_status() !== PHP_SESSION_NONE) {
        session_destroy();
    }

    session_start();
    require "database.php";

    $textOtazky = $database->select('textOtazky', ['[>]Odpovedi'=>["id_odpovedi" => "id"]], '*');

    foreach ($textOtazky as $otazka) {
        $otazka['id'] = bin2hex($otazka['id']);
        $otazka['id_odpovedi'] = bin2hex($otazka['id_odpovedi']);
    }
    print_r($textOtazky);
?>
