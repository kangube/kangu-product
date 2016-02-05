<?php

require_once('class.dbconfig.php');

class advert
{	

	private $conn;
	
	public function __construct()
	{
		$database = new Database();
		$db = $database->dbConnection();
		$this->conn = $db;
    }
	
	public function runQuery($sql)
	{
		$stmt = $this->conn->prepare($sql);
		return $stmt;
	}
	
	public function register($user_first_name, $user_last_name, $user_email, $user_password)
	{
		try
		{
			$new_password = password_hash($upass, PASSWORD_DEFAULT);
			
			$stmt = $this->conn->prepare("INSERT INTO tbl_user(user_firstname, user_lastname, user_email, user_password) 
		                                               VALUES(:ufirstname, :ulastname, :umail, :upass)");
												  
			$stmt->bindparam(":ufirstname", $user_first_name);
			$stmt->bindparam(":ulastname", $user_last_name);
			$stmt->bindparam(":umail", $user_email);
			$stmt->bindparam(":upass", $new_password);										  
				
			$stmt->execute();	
			
			return $stmt;	
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}				
	}

	public function getAll()
		{
			//alle adverts returnen
			$conn = Db::getInstance();
			$allAdverts = $conn->query("SELECT * FROM tbl_advert;");
			return $allAdverts;

		}

	public function getOne()
		{
			//details van 1 advert returnen
			$conn = Db::getInstance();
			$advertNumber = $_GET['id'];
			$allAdverts = $conn->query("SELECT * FROM tbl_advert WHERE advert_id=$advertNumber");
			return $allAdverts;

		}
		
}
?>