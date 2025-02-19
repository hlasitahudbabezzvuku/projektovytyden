<?php

require $_SERVER["DOCUMENT_ROOT"] . "/utils/database.php";
global $database;

$data = $database->get("Games", "stage", [
	"id" => $_GET["game"]
]);

echo $data;

?>
