<?php

require_once '../lib/flight/Flight.php';
require_once 'access.php';
require_once 'user.php';
require_once 'block.php';
require_once 'util.php';

Flight::route('POST /access', function()
{
    if(!check_post_headers(['name', 'auth_client_hash']))
    	return;
    echo json_encode(access_create($_POST['name'], $_POST['auth_client_hash']));
});

Flight::route('GET /salt', function()
{
    echo json_encode(user_generate_client_salt());
});

Flight::route('POST /user', function()
{
    if(!check_post_headers(['name', 'auth_client_salt', 'auth_client_hash', 'enc_client_salt']))
		return ['success' => false];
    echo json_encode(user_create($_POST['name'], $_POST['auth_client_salt'], $_POST['auth_client_hash'], $_POST['enc_client_salt']));
});

//public information
Flight::route('GET /user/@name', function($name)
{
    echo json_encode(user_get($name));
});

//private information
Flight::route('GET /user', function()
{
    echo json_encode(user_get_secret());
});

Flight::route('PUT /user_password', function()
{
    if(!check_put_headers(['auth_client_hash']))
	{
		echo '{"success":false';
		return;
	}
	global $put_data;
    echo json_encode(user_update_password($_POST['auth_client_hash']));
});

Flight::route('PUT /user/main_block_id', function()
{
	if(!check_put_headers(['main_block_id']))
	{
		echo '{"success":false}';
		return;
	}
	global $put_data;
    echo json_encode(user_update_main_block_id($put_data['main_block_id']));
});

Flight::route('DELETE /user', function()
{
    echo json_encode(user_delete());
});

Flight::route('POST /block', function()
{
	if(!check_post_headers(['data']))
		return ['success' => false];
    echo json_encode(block_create($_POST['data']));
});

Flight::route('GET /block/@id', function($id)
{
    echo json_encode(block_get($id));
});

Flight::route('PUT /block/@id', function($id)
{
    if(!check_put_headers(['data']))
	{
		echo '{"success":false}';
		return;
	}
	global $put_data;
    echo json_encode(block_update($id, $put_data['data']));
});

Flight::route('DELETE /block/@id', function($id)
{
    echo json_encode(block_delete($id));
});

Flight::route('GET /block/new/@time', function($time)
{
    echo json_encode(block_get_new($time));
});


//dev
Flight::route('GET /test', function()
{
    require_once("../test.php");
});

Flight::route('GET /reset', function()
{
    require_once("../reset.php");
});

//debug
/*
Flight::map('notFound', function(){
    echo "Handle not found";
});
*/


Flight::start();

?>