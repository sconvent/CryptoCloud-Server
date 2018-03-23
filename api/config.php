<?php

require_once '../lib/medoo.php';

$database = new medoo([
    'database_type' => 'mysql',
    'database_name' => 'cryptoCloud',
    'server' => 'localhost',
    'username' => 'root',
    'password' => 'root',
    'charset' => 'utf8'
]);

$GLOBALS['database'] = $database;

?>