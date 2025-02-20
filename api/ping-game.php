<?php

require $_SERVER["DOCUMENT_ROOT"] . "/utils/database.php";
global $database;

session_start();

if (isset($_SESSION) && session_status() !== PHP_SESSION_NONE) {

  if(empty($database->get("Players", "id", [ "id" => $_SESSION["uuid"] ]))) {
    echo("Player not found");
    die();
  }

  if (empty($database->get("Games", "id", [ "id" => $_SESSION["code"] ]))) {
    echo("Game is no longer avalible");
    die();
  }

  $database->update("Games", [ "last_ping" => time() ], [ "id" => $_SESSION["code"] ]);

} else {
  echo("Not in game");
}

$database->delete("Players", [
  "last_ping[<]" => ( time() - 10 )
]);

?>

