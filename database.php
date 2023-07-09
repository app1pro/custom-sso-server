<?php

require_once __DIR__ . '/config.php';

try {
    $conn = new PDO("mysql:host=".HOST."; dbname=".DB_NAME."; charset=utf8", DB_USERNAME, DB_PASSWORD);
    // echo "Connected to database successfully.";
} catch (PDOException $pe) {
    die("Could not connect to the database:" . $pe->getMessage());
}
