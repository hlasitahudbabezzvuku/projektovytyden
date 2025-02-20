<?php 
  require $_SERVER["DOCUMENT_ROOT"] . "/utils/database.php";
  global $database;
  
  $uuid = hex2bin(urldecode($_GET["uuid"]));

  $player = $database->get("Players", "stage_finished", [
    "id" => $uuid
  ]);
;
  echo json_encode($player);
?>