<?php
require_once 'includes/config.inc.php';
require_once 'Classes/Dbh.php';
require_once 'Classes/Model.php';
require_once 'Classes/Contr.php';
require_once 'Classes/View.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $username = $_POST["username"];
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $email = $_POST["email"];
    $birthdate = $_POST["birthdate"];
    $phoneNumber = $_POST["phone_no"];
    $pwd = $_POST["password"];

    try {
        $signup = new Contr();
        $signup->handleSignup($username, $pwd, $firstname, $lastname, $email, $birthdate, $phoneNumber);
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

<body class="signup-body">
    <div class="signup-container">
        <div class="signup-form">
            <h2 class="text-center mb-4">Sign Up</h2>
            <form id="forma" action="signup.php" method="POST">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" name="username" id="username" />
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="firstname" class="form-label">First Name</label>
                        <input type="text" class="form-control" name="firstname" id="firstname" />
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="lastname" class="form-label">Last Name</label>
                        <input type="text" class="form-control" name="lastname" id="lastname" />
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" id="email" />
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="birthdate" class="form-label">Date of Birth</label>
                        <input type="date" class="form-control" name="birthdate" id="birthdate" />
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="phone_no" class="form-label">Phone Number</label>
                        <input type="tel" class="form-control" name="phone_no" id="phone_no" />
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" id="password" />
                    </div>
                </div>
                <div class="error-message">
                    <?php
                    // Display any signup errors using the View class
                    $err = new View;
                    $err->checkSignupErrors();
                    ?>
                </div>
                <button class="btn btn-primary w-100 mb-3" type="submit" name="submit">Sign Up</button>
                <p class="mt-2 text-center">
                    <span>Already have an account?</span>
                    <a href="login.php" class="link-primary">Sign In</a>
                </p>
            </form>
        </div>
        <div class="signup-image"></div>
    </div>
</body>

</html>