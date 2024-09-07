<?php

require __DIR__ . '/config.php';
require_once __DIR__ . '/database.php';

global $conn;

header('Content-Type: application/json');

// echo '<pre>';
// print_r($_SERVER);
// die;

// Get access token from the GET request.
$access_token = null;
if (isset($_SERVER['HTTP_AUTHORIZATION']) && preg_match('/Bearer\s(\S+)/', $_SERVER['HTTP_AUTHORIZATION'], $matches)) {
    $access_token = $matches[1];
}

if (!$access_token) {
    http_response_code(403);
    die(json_encode(['error' => 'Access Token is not found!']));
}

$sql = 'SELECT * FROM client_tokens WHERE access_token = "'.$access_token.'"';
$result = $conn->query($sql);

if (!$result || $result->rowCount() == 0) {
    http_response_code(403);
    die(json_encode(['error' => 'Access Token is not valid!']));
}

$row = $result->fetch(PDO::FETCH_ASSOC);

$sql = 'SELECT * FROM users WHERE id = '.$row['user_id'].'';
$result = $conn->query($sql);

if (!$result || $result->rowCount() == 0) {
    http_response_code(404);
    die(json_encode(['error' => 'User is not found!']));
}

$row = $result->fetch(PDO::FETCH_ASSOC);

// All check is OK.
unset($row['password']);
die(json_encode($row));
