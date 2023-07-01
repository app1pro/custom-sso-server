<?php

require __DIR__ . '/config.php';

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

if ($code !== ONETIME_CODE) {
    die(json_encode(['error' => 'Code is not found.']));
}

// All check is OK.
// You need to delete the code in the database. Or set it to "used" so it can not be used again.

die(json_encode(['access_token' => ACCESS_TOKEN]));