<?php

function check_post_headers($entries)
{
	if(count($entries) != count($_POST))
		return false;

	foreach ($_POST as $entry => $value)
	{
		if(!in_array($entry, $entries))
			return false;
	}
	return true;
}

function check_put_headers($entries)
{
	global $put_data;
	parse_str(file_get_contents("php://input"),$put_data);

	if(count($entries) != count($put_data))
		return false;

	foreach ($put_data as $entry => $value)
	{
		if(!in_array($entry, $entries))
			return false;
	}
	return true;
}

function randomString($length)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randstring = '';
    for ($i = 0; $i < $length; $i++) {
        $randstring .= $characters[rand(0, strlen($characters)-1)];
    }
    return $randstring;
}

function check_authentication()
{
	global $database, $user_id;
	if (!isset($_SERVER['HTTP_TOKEN']) || empty($_SERVER['HTTP_TOKEN']))
	{
		var_dump($_SERVER);
	    return false;
	}
	$token = $_SERVER['HTTP_TOKEN'];
	$user_id = $database->get('access_token', ['user_id'], ['token' => $token]);
	$user_id = $user_id['user_id'];
	if(!is_null($user_id))
		return true;
	else
		return false;
}

?>