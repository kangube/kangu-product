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

$db_username        = 'root'; //database username
$db_password        = 'root'; //dataabse password
$db_name            = 'kangu-product'; //database name
$db_host            = 'localhost'; //hostname or IP
$item_per_page      = 1; //item to display per page

$mysqli = new mysqli($db_host, $db_username, $db_password, $db_name);
//Output any connection error
if ($mysqli->connect_error) {
    die('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
}
?>