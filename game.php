<?php
    if (isset($_SESSION) || session_status() !== PHP_SESSION_NONE) {
        session_destroy();
    }

    session_start();
    require "database.php";

    $text = $database->select('textOtazky', '*');
    print_r($text);
?>
