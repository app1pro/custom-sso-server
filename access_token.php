<?php

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/database.php';

global $conn;

header('Content-Type: application/json; charset=utf-8');

$client_id = $_POST['client_id'];
$client_secret = $_POST['client_secret'];
$code = $_POST['code'];

if ($client_id !== CLIENT_ID) {
    die(json_encode(['error' => 'Client ID is incorrect.']));
}

if ($client_secret !== CLIENT_SECRET) {
    die(json_encode(['error' => 'Client Secret is incorrect.']));
}

$sql = 'SELECT * FROM onetime WHERE code = "'.$code.'"';
$result = $conn->query($sql);

if (!$result || $result->rowCount() == 0) {
    die(json_encode(['error' => 'Code is not found.']));
}

$row = $result->fetch(PDO::FETCH_ASSOC);

$access_token = md5(microtime());
$created = date('Y-m-d H:i:s');
$sql = "INSERT INTO client_tokens (access_token, client_id, user_id, created) VALUES ('$access_token', '$client_id', ".$row['user_id'].", '$created')";
$result = $conn->exec($sql);

$sql = "UPDATE onetime SET used_on = '".date('Y-m-d H:i:s')."' WHERE code = '".$code."'";
$result = $conn->exec($sql);

// All check is OK.
// You need to delete the code in the database. Or set it to "used" so it can not be used again.

die(json_encode(['access_token' => $access_token]));