<?php

require $_SERVER["DOCUMENT_ROOT"] . "/utils/database.php";
global $database;

session_start();

if (isset($_SESSION) && session_status() !== PHP_SESSION_NONE) {

  if (empty($database->get("Games", "id", [ "id" => $_SESSION["code"] ]))) {
    echo("Něco se pokazilo komunikaci mezi vaším zařízením a serverem (může se jednat o pomalé připojení)");
    die();
  }

  $database->update("Games", [ "last_ping" => time() ], [ "id" => $_SESSION["code"] ]);

} else {
  echo("V tento moment nejste oprávněný/á vstupovat na tuto stránku");
}

// $database->delete("Games", [
//   "last_ping[<]" => ( time() - 6 )
// ]);

?>

