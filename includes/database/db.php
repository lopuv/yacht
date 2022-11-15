<?php
//define database credentials
const DB_HOST = 'localhost';
const DB_USER = 'root';
const DB_PASS = '';
const DB_NAME = 'yachts';

//database object and initializer
class db
{
    public $conn;

    //runs every time a new db object is created
    function __construct()
    {
       $this->open_connection();
    }

    //open the database connection
    public function open_connection()
    {
        //options for pdo attributes
        $opt = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
        //try the connection else trow a exception
        try {
            $this->conn = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8', DB_USER, DB_PASS, $opt);
        }
        catch (PDOException $error)
        {
            echo json_encode($error->getMessage());
        }
    }

    //read from the database based on the table name
    public function read($table_name)
    {
        try
        {
            $sql = "SELECT * FROM " . $table_name ;
            $result = $this->conn->prepare($sql);
            $result->execute();
            $json = json_encode($result->fetch(PDO::FETCH_ASSOC));
            file_put_contents("data.json", $json);
        }
        catch (PDOException $error)
        {
            echo json_encode($error->getMessage());
        }

    }
}