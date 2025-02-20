<?php

require $_SERVER["DOCUMENT_ROOT"] . "/utils/database.php";
global $database;

if(count($database->get("Players", "id", [ "id" => $_SESSION["uuid"] ]))) {
  $database->update("Players", [ "last_ping" => time() ], [ "id" => $_SESSION["uuid"] ]);
} else {
  echo("Error: Player not found");
}

?>

