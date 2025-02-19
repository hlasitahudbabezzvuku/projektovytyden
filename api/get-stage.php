<?php

require $_SERVER["DOCUMENT_ROOT"] . "/utils/database.php";
global $database;

$data = $database->select("Games", "stage", [
	"id" => $_GET["game"]
]);

foreach($data as $item) {
	echo $item . "<br>";
}

?>
