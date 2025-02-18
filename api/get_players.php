<?php

require $_SERVER['DOCUMENT_ROOT'] . "/utils/database.php";
global $database;

$data = $database->select("Players", "name", [
	"game" => $_GET["game"]
]);

foreach($data as $item) {
	echo $item["name"] . "<br>";
}

?>
