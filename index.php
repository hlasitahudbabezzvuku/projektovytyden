<?php

require('Medoo.php');
use Medoo\Medoo;

$database = new Medoo([
	'type' => 'mysql',
	'host' => 'localhost',
	'database' => 'name',
	'username' => 'your_username',
	'password' => 'your_password',
 
	'command' => [
		'SET SQL_MODE=ANSI_QUOTES'
	]
])

?>
