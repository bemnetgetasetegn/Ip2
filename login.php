<?php

require_once 'includes/config.inc.php';
require_once 'Classes/Dbh.php';
require_once 'Classes/Model.php';
require_once 'Classes/Contr.php';
require_once 'Classes/View.php';

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $username = $_POST["username"];
    $pwd = $_POST["password"];

    try {
        $controller = new Contr();
        $controller->handleLogin($username, $pwd);



    } catch (PDOException $e) {
        echo ("Error: ") . $e->getMessage();
    }

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="assets/css/auth.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />

</head>

<body class="body-login">


    <div class="login-container">
        <div class="login-form">
            <h2 class="text-center">Hello Again!</h2>
            <form action="" id="forma" method="POST">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" name="username" id="username" />
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" id="password" />
                </div>
                <button class="btn btn-primary w-100" type="submit" name="submit">Log In</button>
                <p class="text-center"><span style="color:black; font-size:10px;">Don't Have an account?</span> <a
                        class="text-primary" href="signup.php" style="color:blue;">SignUp</a></p>

                <div class="error-message">
                    <?php
                    $err = new View;
                    $err->checkLoginErrors();
                    ?>
                </div>

            </form>
        </div>
        <div class="login-image"></div>
    </div>
</body>

</html>