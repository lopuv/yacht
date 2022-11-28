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
    private $jsonstring;
    private $raw_json;
    private $decoded_json;

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
        } catch (PDOException $error) {
            echo json_encode($error->getMessage());
        }
    }

    //read from the database based on the table name
    public function read_db($table_name, $table_name2 = NULL, $table_name3 = NULL)
    {
        if ($table_name != NULL && $table_name2 == NULL && $table_name3 == NULL) {
            try {
                $sql = "SELECT * FROM " . $table_name;
                $result = $this->conn->prepare($sql);
                $result->execute();
                $json = json_encode($result->fetch(PDO::FETCH_ASSOC));
                $this->write_file($json);
            } catch (PDOException $error) {
                echo json_encode($error->getMessage());
            }
        } elseif ($table_name != NULL && $table_name2 != NULL && $table_name3 == NULL) {
            try {
                $sql = "SELECT * FROM " . $table_name . " LEFT JOIN " . $table_name2 . " ON " . $table_name . ".id";
                $result = $this->conn->prepare($sql);
                $result->execute();
                $json = json_encode($result->fetch(PDO::FETCH_ASSOC));
                $this->write_file($json);
            } catch (PDOException $error) {
                echo json_encode($error->getMessage());
            }
        } elseif ($table_name != NULL && $table_name2 != NULL && $table_name3 != NULL) {
            try {
                $sql = "SELECT * FROM " . $table_name . " LEFT JOIN " . $table_name2 . " ON " . $table_name . ".id LEFT JOIN " . $table_name3 . " ON " . $table_name . ".id";
                $result = $this->conn->prepare($sql);
                $result->execute();
                $json = json_encode($result->fetch(PDO::FETCH_ASSOC));
                $this->write_file($json);
            } catch (PDOException $error) {
                echo json_encode($error->getMessage());
            }
        }
    }

    public function write_file($json)
    {
        file_put_contents("data.json", $json);
    }

    public function get_json()
    {
        $this->jsonstring = file_get_contents("data.json");
        if ($this->jsonstring == NULL) {
            return "jsonstring not found";
        } else {
            $this->decoded_json = json_decode($this->jsonstring, true);
            return $this->decoded_json;
        }
    }

    public function process_data()
    {
        $json = print_r(file_get_contents('php://input'), true);
        if($json)
        {
            file_put_contents('data.json', $json);
            $this->get_json();
        }
    }
}