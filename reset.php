<?php

require_once 'lib/medoo.php';

$database = new medoo([
    'database_type' => 'mysql',
    'database_name' => 'cryptoCloud',
    'server' => 'localhost',
    'username' => 'root',
    'password' => 'root',
    'charset' => 'utf8'
]);


$database->delete('access');
$database->delete('salt');
$database->delete('block');
$database->delete('user');

$files = get_files();
for $file in $files
{
	delete_file($file);
}

?>