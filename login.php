<?php

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/database.php';

global $conn;

$queries = $_SERVER['QUERY_STRING'];

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

    $sql = 'SELECT * FROM users WHERE email = "'.$username.'" AND password = "'.$password.'"';
    $result = $conn->query($sql);

    if (!$result || $result->rowCount() == 0) {
        $error = 'Email or password is incorrect!';
    } else {
        // generate a $code. redirect_url?code=$code.
        $row = $result->fetch(PDO::FETCH_ASSOC);

        $code = md5(microtime());
        $sql = "INSERT INTO onetime (code, client_id, user_id) VALUES ('$code', '$client_id', ".$row['id'].")";
        $result = $conn->exec($sql);

        // $code = ONETIME_CODE;
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
            <h3>Login</h3>
            <!-- Login Form -->
            <form method="POST">
                <input type="text" class="form-control mb-4" name="email" placeholder="email (demo@demo.com)">
                <input type="text" class="form-control mb-4" name="password" placeholder="password (demodemo)">
                <input type="submit" name="submit" class="btn btn-primary" value="Log In">
                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger"><?= $error ?></div>
                <?php endif ?>
            </form>

            <div class="mt-3"><a href="./register.php?<?= $queries ?>">Register</a></div>
        </div>
    </div>
</main>
</body>
</html>
