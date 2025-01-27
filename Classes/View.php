<?php

class View extends Contr
{
    public function checkLoginErrors()
    {
        if (isset($_SESSION['Login_Errors'])) {
            $errors = $_SESSION['Login_Errors'];

            echo '<br>';

            foreach ($errors as $error) {
                echo '<p class="form-error">' . $error . '</p>';
            }

            unset($_SESSION['Login_Errors']);
        }
    }

    public function checkSignupErrors()
    {

        if (isset($_SESSION["Signup_Errors"])) {
            $errors = $_SESSION["Signup_Errors"];

            echo "<br>";

            foreach ($errors as $error) {
                echo "<p class=\"form-error\">" . $error . "</p>";
            }

            unset($_SESSION["Signup_Errors"]);

        }
    }

    public function checkBookingErrors()
    {
        if (isset($_SESSION["Booking_Errors"])) {
            $errors = $_SESSION['Booking_Errors'];

            foreach ($errors as $error) {
                echo "<p class=\"form-error\">" . $error . "</p>";
            }

            unset($_SESSION["Booking_Errors"]);

        }
    }

    public function userProfile()
    {

        echo "<p id=\"username\">" . $_SESSION['username'] . "</p>";
        echo "<p id=\"email\">" . $_SESSION['email'] . "</p>";

    }

    public function adminProfile()
    {

        echo "<p id=\"username\">" . $_SESSION['username'] . "</p>";

    }

    public function logout()
    {

        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
            echo ' <button style="margin-left: 10px" class="logout">
                    <a href="logout.php" style="color: white; font-size: 25px;">
                        <ion-icon name="log-out-outline"></ion-icon>
                    </a>
                </button>';
        }

    }

    public function profile()
    {
        $v = new View;
        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] = true && $_SESSION['role'] === 'user') {
            $v->userProfile();
        } else if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] = true && $_SESSION['role'] === 'admin') {
            $v->adminProfile();
        } else {
            echo '<div class="logsign text-center mt-3">
                    <a href="login.php" class="btn btn-primary me-2">Login</a>
                    <a href="signup.php" class="btn btn-secondary" style="margin-left: 10px;">Sign up</a>
                </div>';
        }
    }

    public function flightStatusLink()
    {

        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] = true) {
            echo '<a href="flightStatus.php" class="navbar-link" data-nav-link>Flight Status</a>';
        }
    }





}
