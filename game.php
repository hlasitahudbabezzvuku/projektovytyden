<?php
    if (isset($_SESSION) || session_status() !== PHP_SESSION_NONE) {
        session_destroy();
    }

    session_start();
    require $_SERVER["DOCUMENT_ROOT"] . "/utils/database.php";
?>
