<?php
  require_once 'Medoo.php';
  use Medoo\Medoo;

  $database = new Medoo([
    'type' => 'mysql',
    'host' => 'sql105.infinityfree.com',
    'database' => 'if0_38314982_projektovy_tyden',
    'username' => 'if0_38314982',
    'password' => 'ojc0EveY78Zip',
    'command' => [
      'SET SQL_MODE=ANSI_QUOTES'
    ]
  ]);
?>
