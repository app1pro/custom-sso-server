<?php

require __DIR__ . '/config.php';

header('Content-Type: application/json; charset=utf-8');

// echo '<pre>';
// print_r($_SERVER);
// die;

$access_token = $_SERVER['HTTP_ACCESS_TOKEN'];
$user_id = $_GET['id'];

if ($access_token !== ACCESS_TOKEN) {
    die(json_encode(['error' => 'Token is not found.']));
}

if ($user_id != ACCESS_TOKEN_FOR_USER) {
    die(json_encode(['error' => 'Token is not connected to this user id.']));
}

if ($user_id != USER_ID) {
    die(json_encode(['error' => 'User is not found.']));
}

// All check is OK.
// You need to delete the code in the database. Or set it to "used" so it can not be used again.

die(json_encode(['id' => USER_ID, 'email' => USERNAME, 'first_name' => FIRST_NAME, 'last_name' => LAST_NAME, 'name' => DISPLAY_NAME]));
