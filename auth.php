<?php

// Start the session
session_start();

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/database.php';

global $conn;

$queries = $_SERVER['QUERY_STRING'];
$auth_user = isset($_SESSION["auth"]) ? $_SESSION["auth"] : null;

$client_id = isset($_GET['client_id']) ? $_GET['client_id'] : null;
$redirect_url = isset($_GET['redirect_url']) ? $_GET['redirect_url'] : null;
$state = isset($_GET['state']) ? $_GET['state']: null;
$error = null;

// echo '<pre>';
// var_dump($_SESSION["auth"]);
// die;

if ($client_id !== CLIENT_ID) {
    die('Auth error! Client ID not valid!');
}

if (!in_array($redirect_url, array_map('trim', explode(',', ALLOWED_REDIRECT_URLS)))) {
    die('Auth error! Redirect_url is not in whitelist!');
}

if (empty($auth_user)) {
    header("Location: ./login.php?redirect_url=".urlencode($_SERVER['REQUEST_URI']));
    exit();
}

if (isset($_POST['allow'])) {
    $code = md5(microtime());
    $sql = "INSERT INTO onetime (code, client_id, user_id) VALUES ('$code', '$client_id', ".$auth_user['id'].")";
    $result = $conn->exec($sql);

    // $code = ONETIME_CODE;
    header("Location: ".$redirect_url.'?code='.$code .'&state='.$state);
    exit();
}

?>

<!DOCTYPE html>
<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
</head>
<body class="p-5 bg-body-tertiary">

<main class="form-signin w-50 m-auto">
    <div class="card shadow-md">
        <div class="card-body">
            <h3>Auth</h3>
            <div class="mb-4">Your account: <strong><?= $auth_user['email'] ?></strong> <a href="./logout.php">Logout</a></div>
            <!-- Login Form -->
            <form method="POST">
                <label class="mb-3 d-block"><strong><?= CLIENT_BRAND_NAME ?></strong> want to connect to your account.</label>
                <div class="mb-4 text-center">
                    <input type="submit" name="allow" class="btn btn-primary" value="Authorize Application">
                    <input type="button" name="deny" class="btn btn-danger" value="Deny">
                </div>

                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger"><?= $error ?></div>
                <?php endif ?>
            </form>

            <div class="mt-3"><small><a href="#">Cancel and go back the website</a></small></div>
        </div>
    </div>
</main>
</body>
</html>