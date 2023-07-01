<?php

require __DIR__ . '/config.php';

$client_id = $_GET['client_id'];
$redirect_url = $_GET['redirect_url'];
$error = null;

if ($client_id !== CLIENT_ID) {
    die('Auth error! Client ID not valid!');
}

if (!in_array($redirect_url, array_map('trim', explode(',', ALLOWED_REDIRECT_URLS)))) {
    die('Auth error! Redirect_url is not in whitelist!');
}

if (isset($_POST['submit'])) {
    $username = $_POST['email'];
    $password = $_POST['password'];

    if ($username !== USERNAME || $password !== PASSWORD) {
        $error = 'Email or password is incorrect!';
    } else {
        // generate a $code. redirect_url?code=$code.
        $code = ONETIME_CODE;
        header("Location: ".$redirect_url.'?code='.$code);
        exit();
    }
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
            <!-- Login Form -->
            <form method="POST">
                <input type="text" class="form-control mb-4" name="email" placeholder="email (<?= USERNAME ?>)">
                <input type="text" class="form-control mb-4" name="password" placeholder="password (<?= PASSWORD ?>)">
                <input type="submit" name="submit" class="btn btn-primary" value="Log In">
                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger"><?= $error ?></div>
                <?php endif ?>
            </form>

        </div>
    </div>
</main>
</body>
</html>
