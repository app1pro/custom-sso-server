<?php

require __DIR__ . '/config.php';
require_once __DIR__ . '/database.php';

global $conn;

header('Content-Type: application/json; charset=utf-8');

// echo '<pre>';
// print_r($_SERVER);
// die;

$access_token = $_POST['access_token'];

$sql = 'SELECT * FROM client_tokens WHERE access_token = "'.$access_token.'"';
$result = $conn->query($sql);

if (!$result || $result->rowCount() == 0) {
    die(json_encode(['error' => 'Access Token is not found.']));
}

$row = $result->fetch(PDO::FETCH_ASSOC);

$sql = 'SELECT * FROM users WHERE id = '.$row['user_id'].'';
$result = $conn->query($sql);

if (!$result || $result->rowCount() == 0) {
    die(json_encode(['error' => 'User is not found.']));
}

$row = $result->fetch(PDO::FETCH_ASSOC);

// All check is OK.
unset($row['password']);
die(json_encode($row));