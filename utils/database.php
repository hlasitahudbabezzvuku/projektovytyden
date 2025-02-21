<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/libs/Medoo.php";
use Medoo\Medoo;

$database = new Medoo([
  "type" => "mariadb",
  "host" => "localhost",
  "database" => "projektovytyden",
  "username" => "php",
  "password" => "php",
  "command" => [
    "SET SQL_MODE=ANSI_QUOTES"
  ]
]);

?>
