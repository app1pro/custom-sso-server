<?php

define('CLIENT_ID', '2e838f2f2652dab5c976381d58463ba6');
define('CLIENT_SECRET', '062a2c8e0e79a247143443b2de98ccacee4a24fc');

define('ALLOWED_REDIRECT_URLS', 'https://signonify.com/openid/custom-sso, http://localhost/app/users/callback, http://yourdomain.com/oauth/callback');

define('USER_ID', 1);
define('USERNAME', 'demo@demo.com');
define('PASSWORD', 'demodemo');
define('FIRST_NAME', 'John');
define('LAST_NAME', 'Doe');
define('DISPLAY_NAME', 'John Doe');

// You need to generate a random values, save to database and has an expiration date. Delete this value after it is used.
define('ONETIME_CODE', '443b2de98ccacee4a24fc062a2c8e0e79a247143');
define('ACCESS_TOKEN', '8e0e7962a2c98ccacee4a24fc0a247143443b2dea247143443b2de');
define('ACCESS_TOKEN_FOR_USER', 1);

// DATABASE
define('HOST', 'localhost');
define('DB_NAME', 'custom_sso_server');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'matkhau');


