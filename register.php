<?php

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/database.php';

global $conn;

$queries = $_SERVER['QUERY_STRING'];
$error = null;
$success = null;

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];

    if (empty($email)) {
        $error = 'Email must be not empty!';
    } elseif (empty($password)) {
        $error = 'Password must be not empty!';
    } elseif (empty($first_name)) {
        $error = 'First Name must be not empty!';
    } elseif (empty($last_name)) {
        $error = 'Last Name must be not empty!';
    }

    if (empty($error)) {
        $sql = 'SELECT * FROM users WHERE email = "'.$email.'"';
        $result = $conn->query($sql);

        if ($result && $result->rowCount() > 0) {
            $error = 'Email is existed! Please use an other one.';
        } else {
            // generate a $code. redirect_uri?code=$code.
            $created = date('Y-m-d H:i:s');
            $sql = "INSERT INTO users (email, password, first_name, last_name, created) VALUES ('$email', '$password', '$first_name', '$last_name', '$created');";
            $result = $conn->exec($sql);

            $success = 'Created new account successfully! Please click the Login button.';
        }
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
            <h3>Register</h3>
            <!-- Login Form -->
            <form method="POST">
                <input type="text" class="form-control mb-4" name="email" placeholder="Email">
                <input type="text" class="form-control mb-4" name="password" placeholder="Password">
                <input type="text" class="form-control mb-4" name="first_name" placeholder="First Name">
                <input type="text" class="form-control mb-4" name="last_name" placeholder="Last Name">
                <input type="submit" name="submit" class="btn btn-primary" value="Register">
                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger py-2"><?= $error ?></div>
                <?php endif ?>

                <?php if (!empty($success)): ?>
                    <div class="alert alert-success py-2"><?= $success ?></div>
                <?php endif ?>
            </form>

            <div class="mt-3"><a href="./login.php?<?= $queries ?>">Login</a></div>

        </div>
    </div>
</main>
</body>
</html>
