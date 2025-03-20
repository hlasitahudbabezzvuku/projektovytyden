<?php

require $_SERVER["DOCUMENT_ROOT"] . "/utils/database.php";
global $database;

session_start();

if (isset($_SESSION) && session_status() !== PHP_SESSION_NONE) {
  
  if (empty($database->get("Games", "id", [ "id" => $_SESSION["code"] ]))) {
    echo("Ten kdo hru vytvořil již není dostupný");
    die();
  }

  if(empty($database->get("Players", "game", [ "game" => $_SESSION["code"] ]))) {
    echo("Něco se pokazilo komunikaci mezi vaším zařízením a serverem (může se jednat o pomalé připojení)");
    die();
  }

  $database->update("Players", [ "last_ping" => time() ], [ "id" => $_SESSION["uuid"] ]);

} else {
  echo("V tento moment nejste oprávněný/á vstupovat na tuto stránku");
}

// $database->delete("Players", [
//   "last_ping[<]" => ( time() - 6 )
// ]);

?>

