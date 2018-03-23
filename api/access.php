<?php

function access_create($name, $client_hash)
{
	global $database;

	$user = $database->get('user', [
			'id',
			'auth_server_salt',
			'auth_password_hash'
		],[
		'name' => $name
	]);

	$options = ['salt' => strval($user['auth_server_salt']), 'cost' => 12];
	$sent_hash = substr(password_hash($client_hash, PASSWORD_BCRYPT, $options), 31, 28);
	if($sent_hash != $user['auth_password_hash'])
	{
		//change (dont return sent and expected)
		$result = ['success' => false, 'result' => $sent_hash, 'expected' => $user['auth_password_hash']];
		return $result;
	}

	$token = randomString(128);
	$database->insert('access_token',[
		'user_id' => $user['id'],
		'token' => $token,
		'valid_until' => time()+3600
	]);
	$result = new stdClass();
	$result->success = true;
	$result->token = $token;
	return $result;
}

?>