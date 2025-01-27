<?php

require_once __DIR__ . '/../includes/config.inc.php';

class Contr extends Model
{

    private function IsInputEmpty($fields)
    {
        foreach ($fields as $field) {
            if (empty($field)) {
                return true;
            }
        }
        return false;
    }

    //Login in Error Handlers

    private function IsUnameInvalid($username)
    {
        $result = $this->getRow($username);
        $uname = $result['username'];
        if (!empty($uname)) {
            return false;
        } else {
            return true;
        }
    }

   


    private function IsPasswordWrong($username, $pwd)
    {
        $hashedPassword = $this->getHashedPassword($username);

        if (!$hashedPassword) {
            return true;
        }
        return !password_verify($pwd, $hashedPassword);
    }

    //Sign up Error Handlers

    private function IsEmailInvalid($email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        } else {
            return false;
        }
    }

    private function isUsernameTaken($username)
    {
        $result = $this->getRow($username);
        $uname = $result['username'];
        if (!empty($uname)) {
            return true;
        } else {
            return false;
        }
    }

    private function isEmailTaken($email)
    {

        if ($this->getEmail($email)) {
            return true;
        } else {
            return false;
        }
    }


    //Check For Login Errors

    public function handleLogin($username, $pwd)
    {
        $errors = [];

        if ($this->IsInputEmpty([$username, $pwd])) {
            $errors["Input_Error"] = "The input is empty";
        }
        if ($this->IsUnameInvalid($username)) {
            $errors["Username_invalid"] = "Username Is Not found";
        }
        if ($this->IsPasswordWrong($username, $pwd)) {
            $errors["Password_Wrong"] = "The password is wrong";
        }

        if (!empty($errors)) {
            $_SESSION["Login_Errors"] = $errors;
            header("location: login.php");
            exit;
        } else {

            $row = $this->getRow($username);
            $role = $row['role'];
            $email = $row['email'];
            $_SESSION['logged_in'] = true;
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $role;

            if ($role === 'user') {
                $_SESSION['email'] = $email;
                $userId = $this->getUserId($username);
                $_SESSION['user_id'] = $userId;

                header("Location: index.php");
                die();
            } else if ($role === 'admin') {
                header("location: admin.php");
            }

        }
    }

    //handle signup

    public function handleSignup($username, $pwd, $firstname, $lastname, $email, $birthdate, $phoneNumber)
    {

        $errors = [];

        if ($this->isInputEmpty([$username, $pwd, $firstname, $lastname, $email, $birthdate, $phoneNumber])) {
            $errors["Input_Error"] = "The Field Is Empty";
        }
        if ($this->IsEmailInvalid($email)) {
            $errors["Invalid_Email"] = "Invalid Email";
        }
        if ($this->isUsernameTaken($username)) {
            $errors["Username_Taken"] = "The Username Is Taken";
        }
        if ($this->isEmailTaken($username)) {
            $errors["Email_Taken"] = "The Email Is Taken";
        }
        if (strlen($pwd < 6)) {
            $errors['pwd_Length'] = "Your password must be 6 letters";
        }
        if (!strtotime($birthdate)) {
            $errors['invalid_birthdate'] = "Invalid birthdate";
        }

        if (!empty($errors)) {
            $_SESSION["Signup_Errors"] = $errors;
            header("Location: signup.php");
            exit;
        } else {
            $this->setUser($username, $pwd, $firstname, $lastname, $email, $birthdate, $phoneNumber);
            echo '<script>
                alert("Signup success! Now log in.");
                window.location.href = "login.php";
            </script>';
            exit;
        }

    }



    //Insert travler page



    public function handleTravler($departureData, $returnDate, $destination, $username)
    {
        $errors = [];
        if ($this->IsInputEmpty([$departureData, $returnDate, $destination])) {
            $errors["Empty_fields"] = "Please Fill In the Fields";
        }

        if (strtotime($departureData) < time()) {
            $errors["Invalid_Departure_Date"] = "The departure date cannot be in the past";
        }

        if (strtotime($returnDate) < strtotime($departureData)) {
            $errors["Invalid_Return_Date"] = "The return date cannot be before the departure date";
        }

        if (!empty($errors)) {
            $_SESSION["Booking_Errors"] = $errors;
            header("Location: insertTraveler.php");
            exit;

        } else {
            $this->setTravler($departureData, $returnDate, $destination, $username);
            echo '<script>
                alert("Booking Success!");
                window.location.href = "insertTraveler.php";
            </script>';
            exit;
        }

    }


    public function travelInfo($username)
    {
        return $this->getTravelInfo($username);
    }

    public function allTables($username)
    {
        return $this->getAllTable($username);
    }

    public function deleteUser($username)
    {
        $this->deleteUserTable($username);
    }

    public function deleteTravel($userid)
    {
        $this->deleteTravelTable($userid);
    }

    public function insertdestination($image, $location, $description, $fee)
    {
        $this->setDestination($image, $location, $description, $fee);
    }

    public function destinationTable()
    {
        return $this->getDestination();
    }

    public function updateDestination($image_path, $location, $description, $fee, $id)
    {
        $this->uDestination($image_path, $location, $description, $fee,  $id);
    }

    public function deleteDestination($id)
    {
        $this->dDestination($id);
    }
}