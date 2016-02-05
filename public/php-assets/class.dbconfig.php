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
?>