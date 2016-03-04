<?php

require_once('class.dbconfig.php');

class advert
{	
	private $m_iUserId;
	private $m_sDescription;
	private $m_iPrice;
	private $m_iNumberChildren;
	private $m_sSchool;
	private $m_iMobileNumber;
	private $m_iHomeNumber;
	private $m_sEmail;
	private $m_sHomeAdress;
	private $m_sHomeCity;
	private $m_sTransportation;
	private $m_sServices;

	private $conn;
	
	public function __construct() {
		$database = new Database();
		$db = $database->dbConnection();
		$this->conn = $db;
    }

    public function __set($p_sProperty, $p_sValue) {
		switch ($p_sProperty) 
		{
			case 'UserId':
				$this->m_iUserId = $p_sValue;
				break;

			case 'Description':
				$this->m_sDescription = $p_sValue;
				break;

			case 'Price':
				$this->m_iPrice = $p_sValue;
				break;

			case 'NumberChildren':
				$this->m_iNumberChildren = $p_sValue;
				break;

			case 'School':
				$this->m_sSchool = $p_sValue;
				break;

			case 'MobileNumber':
				$this->m_iMobileNumber = $p_sValue;
				break;

			case 'HomeNumber':
				$this->m_iHomeNumber = $p_sValue;
				break;

			case 'Email':
				$this->m_sEmail = $p_sValue;
				break;

			case 'HomeAdress':
				$this->m_sHomeAdress = $p_sValue;
				break;

			case 'HomeCity':
				$this->m_sHomeCity = $p_sValue;
				break;

			case 'Transportation':
				$this->m_sTransportation = $p_sValue;
				break;

			case 'Services':
				$this->m_sServices = $p_sValue;
				break;
		}
	}

	public function __get($p_sProperty) {
		switch ($p_sProperty) 
		{
			case 'UserId':
				return $this->m_iUserId;
				break;

			case 'Description':
				return $this->m_sDescription;
				break;

			case 'Price':
				return $this->m_iPrice;
				break;

			case 'NumberChildren':
				return $this->m_iNumberChildren;
				break;

			case 'School':
				return $this->m_sSchool;
				break;

			case 'MobileNumber':
				return $this->m_iMobileNumber;
				break;

			case 'HomeNumber':
				return $this->m_iHomeNumber;
				break;

			case 'Email':
				return $this->m_sEmail;
				break;

			case 'HomeAdress':
				return $this->m_sHomeAdress;
				break;

			case 'HomeCity':
				return $this->m_sHomeCity;
				break;

			case 'Transportation':
				return $this->m_sTransportation;
				break;

			case 'Services':
				return $this->m_sServices;
				break;
		}
	}
	
	public function Save() {
		$conn = Db::getInstance();
		$advert_query = "INSERT INTO tbl_advert(fk_user_id, advert_description, advert_price, advert_spots, advert_school, advert_transport) VALUES ('$this->UserId', '$this->Description', '$this->Price', '$this->NumberChildren', '$this->School', '$this->Transportation');";
		$advert_query .= "INSERT INTO tbl_user(user_mobile_number, user_home_number, user_adress, user_city) VALUES ('$this->MobileNumber', '$this->HomeNumber', '$this->HomeAdress', '$this->HomeCity') WHERE user_id = '$this->UserId';";

	   	$statement = $conn->prepare($advert_query);
		$statement->execute();
		$last_created_id = $conn->lastInsertId();

		$services_query .= "INSERT INTO tbl_service(fk_advert_id, service_name) VALUES ";
		$iterator = new ArrayIterator($this->Services);
		$cachingiterator = new CachingIterator($iterator);

		foreach ($cachingiterator as $value)
	    {
	        $services_query .= "('$last_created_id', '".$cachingiterator->current()."')";

	        if($cachingiterator->hasNext())
	        {
	            $services_query .= ", ";
	        }
	    }

	    $statement = $conn->prepare($services_query);
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
}
?>