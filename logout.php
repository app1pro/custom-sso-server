<?php

// Start the session
session_start();

require_once __DIR__ . '/config.php';

session_destroy();

header("Location: login.php");
exit();

?>
