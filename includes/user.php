<?php

class user
{
    private $username;
    private $password;
    public $json;


    public function check_json()
    {
       if (!isset($this->json['username']))
       {
           echo "no value";
       }
       else
       {
           $this->register();
       }
    }

    public function register()
    {
        global $db;
        $this->username = $this->json["username"];
        $this->password = $this->json["password"];
        try {
            $sql = "SELECT * FROM user WHERE username= ?";
            $result = $db->conn->prepare($sql);
            $result->execute(array($this->username));
            $data = $result->fetch(PDO::FETCH_ASSOC);
            if ($data == NULL)
            {
                $sql = "INSERT INTO user (username, password) VALUES (:username, :password)";
                $result = $db->conn->prepare($sql);
                $result->bindParam(':username', $this->username);
                $result->bindParam(':password', $this->password);
                $result->execute();
                session_start();
                $_SESSION['user_id'] = $data['id'];
                $db->write_file(json_encode("session started"));
            }
            else
            {
                if ($data["password"] == $this->password)
                {
                    session_start();
                    $_SESSION['user_id'] = $data['id'];
                    $db->write_file(json_encode("session started"));
                }
                else
                {
                    $db->write_file(json_encode("password was wrong"));
                }
            }
        } catch (PDOException $error) {
            echo json_encode($error->getMessage());
        }
    }
    }