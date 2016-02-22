<?php

require_once('class.dbconfig.php');

class advert
{	
	private $m_sID;
	private $m_sName;
	private $m_sInfo;

	private $conn;
	
	public function __construct()
	{
		$database = new Database();
		$db = $database->dbConnection();
		$this->conn = $db;
    }

    public function __set($p_sProperty, $p_sValue)
		{
			switch ($p_sProperty) 
			{
				case 'ID':
					$this->m_sID = $p_sValue;
					break;

				case 'Name':
					if(empty($p_sValue))
						{
							throw new Exception("Name cannot be empty");
						}
					else 
						{
							$this->m_sName = $p_sValue;
						};
					break;

				case 'Info':
					$this->m_sInfo = $p_sValue;
					break;
			}
		}

	public function __get($p_sProperty)
		{
			switch ($p_sProperty) 
			{
				case 'ID':
					return $this->m_sID;
					break;

				case 'Name':
					return $this->m_sName;
					break;

				case 'Info':
					return $this->m_sInfo;
					break;
			}
		}
	
	public function Save()
		{

			$conn = Db::getInstance();
			//$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
			$statement = $conn->prepare("INSERT INTO tbl_advert
				(advert_id, advert_name, advert_info) 
				VALUES 
				(:ID, :name, :info)");
			$statement->bindValue(':ID', $this->ID );
			$statement->bindValue(':name', $this->Name );
			$statement->bindValue(':info', $this->Info );
		
			$statement->execute();

			//echo "Advert created";
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