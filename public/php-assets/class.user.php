<?php

require_once('class.dbconfig.php');

class USER
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
	
	
	public function doLogin($user_mail, $user_password)
	{
		try
		{
			$stmt = $this->conn->prepare("SELECT user_id, user_email, user_password FROM tbl_user WHERE user_email=:umail ");
			$stmt->execute(array(':umail'=>$user_mail));
			$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
			if($stmt->rowCount() == 1)
			{
				if(password_verify($user_password, $userRow['user_password']))
				{
					$_SESSION['user_session'] = $userRow['user_id'];
					return true;
				}
				else
				{
					return false;
				}
			}
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}
	
	public function is_loggedin()
	{
		if(isset($_SESSION['user_session']))
		{
			return true;
		}
	}
	
	public function redirect($url)
	{
		header("Location: $url");
	}
	
	public function doLogout()
	{
		session_destroy();
		unset($_SESSION['user_session']);
		return true;
	}
}
?>