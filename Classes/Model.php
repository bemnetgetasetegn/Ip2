<?php

class Model extends Dbh
{

    protected function getRow($username)
    {
        $query = "SELECT * FROM users WHERE username = :username;";
        $stmt = $this->connect()->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }




    protected function getUser($username)
    {
        $query = "SELECT username FROM users WHERE username = :username;";
        $stmt = $this->connect()->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }



    protected function getUserId($username)
    {
        $query = "SELECT id FROM users WHERE username = :username;";
        $stmt = $this->connect()->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['id'] ?? null;
    }


    protected function getUnamePwdEmail($username)
    {
        $query = "SELECT password, email FROM users WHERE username = :username;";
        $stmt = $this->connect()->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    protected function getEmail($email)
    {

        $query = "SELECT email FROM users WHERE email = :email;";
        $stmt = $this->connect()->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }


    protected function getHashedPassword($username)
    {
        $result = $this->getRow($username);
        return $result ? $result['password'] : null;

    }

    //insert Into users table

    protected function setUser($username, $pwd, $firstname, $lastname, $email, $birthdate, $phoneNumber)
    {
        $query = "INSERT INTO users (username, password, firstname, lastname, email, birthdate, phoneNumber) VALUES (:username, :password, :firstname, :lastname, :email, :birthdate, :phoneNumber);";
        $stmt = $this->connect()->prepare($query);

        $options = [
            'cost' => 12
        ];

        $hashedpwd = password_hash($pwd, PASSWORD_BCRYPT, $options);

        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $hashedpwd);
        $stmt->bindParam(':firstname', $firstname);
        $stmt->bindParam(':lastname', $lastname);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':birthdate', $birthdate);
        $stmt->bindParam(':phoneNumber', $phoneNumber);
        $stmt->execute();

    }

    //Insert into travlebook table

    protected function setTravler($departureData, $returnDate, $destination, $username)
    {
        $query = "INSERT INTO travelbooking (departure_date, return_date, destination, user_id) VALUES (:departure_date, :return_date, :destination, :user_id);";
        $stmt = $this->connect()->prepare($query);

        $userId = $this->getUserId($username);

        $stmt->bindParam(':departure_date', $departureData);
        $stmt->bindParam(':return_date', $returnDate);
        $stmt->bindParam(':destination', $destination);
        $stmt->bindParam(':user_id', $userId);

        $stmt->execute();

    }


    protected function getTravelInfo($username)
    {

        $userInfo = $this->getRow($username);
        $userId = $userInfo['id'];


        $query = "SELECT * FROM travelbooking WHERE user_id = :user_id";
        $stmt = $this->connect()->prepare($query);
        $stmt->bindParam(":user_id", $userId);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;

    }

    protected function getAllTable($username)
    {


        $userInfo = $this->getRow($username);
        $userId = $userInfo['id'];


        $query = "SELECT DISTINCT users.*, travelbooking.* FROM users LEFT JOIN travelbooking ON users.id = travelbooking.user_id WHERE users.username != 'admin';";

        $stmt = $this->connect()->prepare($query);
        // $stmt->bindParam(":user_id", $userId);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;

    }

    protected function deleteUserTable($username)
    {
        $query = "DELETE FROM users WHERE username = :username;";
        $stmt = $this->connect()->prepare($query);
        $stmt->bindParam(":username", $username);
        $stmt->execute();
    }

    protected function deleteTravelTable($id)
    {
        $query = "DELETE FROM travelbooking WHERE id = :id;";
        $stmt = $this->connect()->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
    }

    protected function setDestination($image, $location, $description, $fee)
    {
        $query = "INSERT INTO destination (image, location, description, fee) VALUES (:image, :location, :description, :fee);";
        $stmt = $this->connect()->prepare($query);
        $stmt->bindParam(':image', $image);
        $stmt->bindParam(':location', $location);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':fee', $fee);
        $stmt->execute();
    }

    protected function getDestination()
    {
        $query = "SELECT * FROM destination";
        $stmt = $this->connect()->prepare($query);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    protected function uDestination($image_path, $location, $description, $fee, $id)
    {
        $query = "UPDATE destination SET image = :image, location = :location, description = :description, fee = :fee WHERE id = :id;";
        $stmt = $this->connect()->prepare($query);
        $stmt->bindParam(':image', $image_path);
        $stmt->bindParam(':location', $location);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':fee', $fee);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

    protected function dDestination($id)
    {
        $query = "DELETE FROM destination WHERE id=:id";
        $stmt = $this->connect()->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }
}