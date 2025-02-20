<?php

require $_SERVER["DOCUMENT_ROOT"] . "/utils/database.php";
global $database;

session_start();

if (isset($_SESSION) && session_status() !== PHP_SESSION_NONE) {
  if(!empty($database->get("Players", "id", [ "id" => $_SESSION["uuid"] ]))) {
    if (!empty($database->get("Games", "id", [ "id" => $_SESSION["game"] ]))) {
      $database->update("Players", [ "last_ping" => time() ], [ "id" => $_SESSION["uuid"] ]);
    } else {
      echo("Game is no longer avalible");
    }
  } else {
    echo("Error: Player not found");
  }
} else {
  echo("Error: Not in game");
}

$database->delete("Players", [
  "last_ping[<]" => ( time() - 20 )
]);

?>

