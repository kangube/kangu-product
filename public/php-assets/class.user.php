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

	public function hasAdvert($user_id)
	{
		try
		{
			$user_has_advert = $this->conn->prepare("SELECT advert_id FROM tbl_advert WHERE fk_user_id=:user_id");
			$user_has_advert->execute(array(":user_id"=>$user_id));
			if($user_has_advert->rowCount() == 1) {
				return true;
			}
			else {
				return false;
			}
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}
	
	public function register($user_first_name, $user_last_name, $user_email, $user_password)
	{
		try
		{
			$new_password = password_hash($user_password, PASSWORD_DEFAULT);
			
			$stmt = $this->conn->prepare("INSERT INTO tbl_user(user_firstname, user_lastname, user_email, user_password, user_image_path) 
		                                               VALUES(:ufirstname, :ulastname, :umail, :upass, '../assets/user-profile-images/default-profile-image.png')");
												  
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
	
	
	public function doLogin($user_email, $user_password)
	{
		try
		{
			$stmt = $this->conn->prepare("SELECT user_id, user_email, user_password FROM tbl_user WHERE user_email=:umail ");
			$stmt->execute(array(':umail'=>$user_email));
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
}

?>