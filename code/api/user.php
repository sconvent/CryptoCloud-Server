<?php

function user_create($name, $auth_client_salt, $client_hash, $enc_client_salt)
{
	global $database; 

	$auth_server_salt = randomString(22);
	$options = ['salt' => $auth_server_salt, 'cost' => 12];
	$hash = substr(password_hash($client_hash, PASSWORD_BCRYPT, $options), 31, 28);

	$database->insert('user', [
		'name' => $name,
		'auth_client_salt' => $auth_client_salt,
		'auth_server_salt' => $auth_server_salt,
		'enc_client_salt' => $enc_client_salt,
		//'main_block_id' => 'NULL',
		'auth_password_hash' => $hash
	]);

	return ['success' => true];
}

function user_get($name)
{
	global $database;
	$result = $database->get('user', ['auth_client_salt', 'auth_server_salt'], ['name' => $name]);
	$result['success'] = true;
	return $result;
}

function user_get_secret()
{
	if(!check_authentication())
		return ['success' => false];
	global $database, $user_id;
	$result = $database->get('user', ['enc_client_salt', 'main_block_id'], ['id' => $user_id]);
	$result['success'] = true;
	return $result;
}

function user_update_password($auth_client_hash)
{
	//to be finished
	if(!check_authentication())
		return ['success' => false];
	global $database, $user_id;
	//$database->update('user', ['main_block_id' => $main_block_id], ['id' => $user_id])
	return ['success' => true];
}

function user_update_main_block_id($main_block_id)
{
	if(!check_authentication())
		return ['success' => false];
	global $database, $user_id;
	$database->update('user', ['main_block_id' => $main_block_id], ['id' => $user_id]);
	return ['success' => true];
}

function user_delete()
{
	if(!check_authentication())
		return ['success' => false];
	global $database, $user_id;
	$database->update('user', ['deleted' => true], ['id' => $user_id]);
	return ['success' => true];
}

?>