<?php

require_once('class.dbconfig.php');

class advert
{	
	private $m_sID;
	private $m_sSchool;
	private $m_sDescription;

	private $conn;
	
	public function __construct() {
		$database = new Database();
		$db = $database->dbConnection();
		$this->conn = $db;
    }

    public function __set($p_sProperty, $p_sValue) {
		switch ($p_sProperty) 
		{
			case 'ID':
				$this->m_sID = $p_sValue;
				break;

			case 'School':
				$this->m_sSchool = $p_sValue;
				break;

			case 'Description':
				$this->m_sDescription = $p_sValue;
				break;
		}
	}

	public function __get($p_sProperty) {
		switch ($p_sProperty) 
		{
			case 'ID':
				return $this->m_sID;
				break;

			case 'School':
				return $this->m_sSchool;
				break;

			case 'Description':
				return $this->m_sDescription;
				break;
		}
	}
	
	public function Save() {
		$conn = Db::getInstance();
		$statement = $conn->prepare("INSERT INTO tbl_advert
			(advert_id, advert_description) 
			VALUES 
			(:ID, :Description)");
		$statement->bindValue(':ID', $this->ID );
		$statement->bindValue(':Description', $this->Description );
		$statement->execute();
	}
	
	public function getAll() {
		$conn = Db::getInstance();
		$allAdverts = $conn->query("SELECT * FROM tbl_advert");
		return $allAdverts;
	}

	public function getOne() {
		$conn = Db::getInstance();
		$advertNumber = $_GET['id'];
		$oneAdvert = $conn->query("SELECT * FROM tbl_advert LEFT JOIN tbl_user ON tbl_advert.fk_user_id=tbl_user.user_id WHERE tbl_advert.advert_id=$advertNumber");
		return $oneAdvert;
	}

	public function getSimilar() {
		$conn = Db::getInstance();
		$advertNumber = $_GET['id'];
		$oneAdvert = $conn->query("SELECT * FROM tbl_advert LEFT JOIN tbl_user ON tbl_advert.fk_user_id=tbl_user.user_id WHERE tbl_advert.advert_id!=$advertNumber");
		return $oneAdvert;
	}
}
?>