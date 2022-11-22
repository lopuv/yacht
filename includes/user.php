<?php

class user
{
    private $id;
    private $username;
    private $password;
    public $json;

    public function register()
    {
        global $db;
        $this->id = $this->json["id"];
        $this->username = $this->json["username"];
        $this->password = $this->json["password"];
        try {
            $sql = "SELECT username FROM user WHERE id =". $this->id;
            echo $sql;
            $result = $db->conn->prepare($sql);
            $result->execute();
            $data = $result->fetch(PDO::FETCH_ASSOC);
            if ($data == NULL)
            {
                $sql = "INSERT INTO user (username, password) VALUES (:username, :password)";
                $result = $db->conn->prepare($sql);
                $result->bindParam(':username', $this->username);
                $result->bindParam(':password', $this->password);
                $result->execute();
                $db->write_file(json_encode("register succeeded"));
            }
            else
            {
                echo "this user already exists";
            }
        } catch (PDOException $error)
        {
            echo json_encode($error->getMessage());
        }



    }
}