<?php

function block_create($data)
{
	if(!check_authentication())
		return ['success' => false];
	global $database, $user_id;

	$database->insert('block', ['user_id' => $user_id, 'last_changed' => time(), 'content' => $data]);
	$block_id = $database->max('block', 'id');

	$result = new stdClass();
	$result->success = true;
	$result->block_id = $block_id;
	return $result;
}

function block_get($block_id)
{
	if(!check_authentication())
		return ['success' => false];
	global $database, $user_id;

	$block = $database->get('block', ['user_id', 'last_changed', 'content'], ['id' => $block_id]);
	if($block['user_id'] != $user_id)
		return ['success' => false];
	return ['success' => true, 'data' => $block['content'], 'last_changed' => $block['last_changed']];
}

function block_update($block_id, $data)
{
	if(!check_authentication())
		return ['success' => false];
	global $database, $user_id;

	$block = $database->get('block', ['user_id'], ['id' => $block_id]);
	if($block['user_id'] != $user_id)
		return ['success' => false];
	$database->update('block', ['last_changed' => time(), 'content' => $data], ['id'=>$block_id]);

	$result = new stdClass();
	$result->success = true;
	return $result;
}

function block_delete($block_id)
{
	if(!check_authentication())
		return ['success' => false];
	global $database, $user_id;

	$block = $database->get('block', ['user_id'], ['id' => $block_id]);
	if($block['user_id'] != $user_id)
		return ['success' => false];
	$database->update('block', ['deleted' => true], ['id'=>$block_id]);

	$result = new stdClass();
	$result->success = true;
	return $result;
}

function block_get_new($time)
{
	if(!check_authentication())
		return ['success' => false];	
	global $database, $user_id;

	$result = $database->get('block', ['block_id'], ['last_changed[>]' => $time]);
	return $result;
}

?>