<?php

/*
$options = ['salt' => 'testsalt12345673245345', 'cost' => 12];
$hash = password_hash('password', PASSWORD_BCRYPT, $options);
echo $hash.'</br>';
$hash = substr($hash, 31, 28);
echo $hash.'</br>';

echo randomString(22);

function randomString($length)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randstring = '';
    for ($i = 0; $i < $length; $i++) {
        $randstring .= $characters[rand(0, strlen($characters)-1)];
    }
    return $randstring;
}
*/

//echo time();

/*
require_once 'lib/medoo.php';

$database = new medoo([
    'database_type' => 'mysql',
    'database_name' => 'cryptoCloud',
    'server' => 'localhost',
    'username' => 'root',
    'password' => 'root',
    'charset' => 'utf8'
]);

$user = $database->get('user', [
			'id',
			'auth_server_salt',
			'auth_password_hash'
		],[
		'name' => 'testuser'
	]);

var_dump($user);

var_dump($database->error());

*/

echo time();
echo '</br>';
echo time()+3600;

?>