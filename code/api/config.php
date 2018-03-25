<?php

require_once '../lib/medoo.php';

$database = new medoo([
    'database_type' => 'mysql',
    'database_name' => 'cryptoCloud',
    'server' => 'mysql',
    'username' => 'cryptoclouduser',
    'password' => 'cryptocloudpw',
    'charset' => 'utf8'
]);

$GLOBALS['database'] = $database;

?>