<?php
class Database
{   
    private $host = "localhost";
    private $db_name = "kangu-product";
    private $username = "root";
    private $password = "root";
    public $conn;
     
    public function dbConnection()
	{
     
	    $this->conn = null;    
        try
		{
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);	
        }
		catch(PDOException $exception)
		{
            echo "Connection error: " . $exception->getMessage();
        }
         
        return $this->conn;
    }
}

class Db 
{
    private static $db; //static = wijzigt niet per object

    public static function getInstance()
    {
        //static = geen object nodig om aan te roepen
        if(self::$db != null)
        {
            return self::$db;
        }
        else
        {
            self::$db = new PDO('mysql:host=localhost; dbname=kangu-product', 'root', 'root');
            return self::$db;
        }
    }
}

$db_username        = 'root';
$db_password        = 'root';
$db_name            = 'kangu-product';
$db_host            = 'localhost';
$item_per_page      = 12;
$item_per_page_reviews = 4;

$mysqli = new mysqli($db_host, $db_username, $db_password, $db_name);

if ($mysqli->connect_error) {
    die('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
}
?>