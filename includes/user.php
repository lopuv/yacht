<?php

class user
{
    private $username;
    private $password;
    public $json;

    public function register()
    {
        global $db;
        $this->username = $this->json["username"];
        $this->password = $this->json["password"];
        try {
            $sql = "SELECT username FROM user ";
            $result = $db->conn->prepare($sql);
            $result->execute();
            $data = $result->fetch(PDO::FETCH_ASSOC);
            var_dump($data);
            if ($data['username'] != $this->username) {
                $sql = "INSERT INTO user (username, password) VALUES (:username, :password)";
                $result = $db->conn->prepare($sql);
                $result->bindParam(':username', $this->username);
                $result->bindParam(':password', $this->password);
                $result->execute();
                $db->write_file(json_encode("register succeeded"));
            } else {
                echo "this user already exists";
            }
        } catch (PDOException $error) {
            echo json_encode($error->getMessage());
        }
    }
    }