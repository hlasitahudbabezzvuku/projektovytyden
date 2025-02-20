<?php

require $_SERVER["DOCUMENT_ROOT"] . "/utils/database.php";
global $database;

session_start();

if (isset($_SESSION) && session_status() !== PHP_SESSION_NONE) {
  
  if (empty($database->get("Games", "id", [ "id" => $_SESSION["code"] ]))) {
    echo("Game is no longer avalible");
    die();
  }

  if(empty($database->get("Players", "game", [ "game" => $_SESSION["code"] ]))) {
    echo("Player not found");
    die();
  }

  $database->update("Players", [ "last_ping" => time() ], [ "id" => $_SESSION["uuid"] ]);

} else {
  echo("Not in game");
}

$database->delete("Players", [
  "last_ping[<]" => ( time() - 10 )
]);

?>

