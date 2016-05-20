<?php

require_once('class.dbconfig.php');

class advert
{	
	private $m_iUserId;
	private $m_sDescription;
	private $m_iPrice;
	private $m_iNumberChildren;
	private $m_sChildFirstName;
	private $m_sChildLastName;
	private $m_sChildClass;
	private $m_sSchool;
	private $m_iMobileNumber;
	private $m_iHomeNumber;
	private $m_sEmail;
	private $m_sHomeAdress;
	private $m_sHomeCity;
	private $m_sTransportation;
	private $m_sServices;
	private $m_sAvailableDates;
	private $m_sAvailableStartTimes;
	private $m_sAvailableEndTimes;

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

			case 'ChildFirstName':
				$this->m_sChildFirstName = $p_sValue;
				break;

			case 'ChildLastName':
				$this->m_sChildLastName = $p_sValue;
				break;

			case 'ChildClass':
				$this->m_sChildClass = $p_sValue;
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

			case 'AvailableDates':
				$this->m_sAvailableDates = $p_sValue;
				break;

			case 'AvailableStartTimes':
				$this->m_sAvailableStartTimes = $p_sValue;
				break;

			case 'AvailableEndTimes':
				$this->m_sAvailableEndTimes = $p_sValue;
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

			case 'ChildFirstName':
				return $this->m_sChildFirstName;
				break;

			case 'ChildLastName':
				return $this->m_sChildLastName;
				break;

			case 'ChildClass':
				return $this->m_sChildClass;
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

			case 'AvailableDates':
				return $this->m_sAvailableDates;
				break;

			case 'AvailableStartTimes':
				return $this->m_sAvailableStartTimes;
				break;

			case 'AvailableEndTimes':
				return $this->m_sAvailableEndTimes;
				break;
		}
	}
	
	public function Save() {
		$conn = Db::getInstance();
		$advert_query = "INSERT INTO tbl_advert(fk_user_id, advert_description, advert_price, advert_spots, advert_school, advert_transport) VALUES ('$this->UserId', '$this->Description', '$this->Price', '$this->NumberChildren', '$this->School', '$this->Transportation');";
		$advert_query .= "UPDATE tbl_user SET user_mobile_number = '$this->MobileNumber', user_home_number = '$this->HomeNumber', user_adress = '$this->HomeAdress', user_city = '$this->HomeCity' WHERE user_id = '$this->UserId';";

	   	$statement = $conn->prepare($advert_query);
		$statement->execute();
		$last_created_id = $conn->lastInsertId();

		$services_dates_query = "";

		$services_dates_query .= "INSERT INTO tbl_service(fk_advert_id, service_name) VALUES ";
		$iterator = new ArrayIterator($this->Services);
		$cachingiterator = new CachingIterator($iterator);

		foreach ($cachingiterator as $value)
	    {
	        $services_dates_query .= "('$last_created_id', '".$cachingiterator->current()."')";

	        if($cachingiterator->hasNext())
	        {
	            $services_dates_query .= ", ";
	        }
	    }

	    $services_dates_query .= "; ";

	    $services_dates_query .= "INSERT INTO tbl_availability(fk_advert_id, availability_date, availability_time_start, availability_time_end, availability_spots) VALUES ";

		foreach($this->AvailableDates as $key => $d)
		{
			$services_dates_query .= "('$last_created_id', '".$d."', '".$this->AvailableStartTimes[$key]."', '".$this->AvailableEndTimes[$key]."', '".$this->NumberChildren."'), ";
		}

		$services_dates_query = rtrim($services_dates_query,', ').";";
	   	$statement = $conn->prepare($services_dates_query);
		$statement->execute();

	   	$children_information_query = "INSERT INTO tbl_child(child_first_name, child_last_name, child_school, child_class) VALUES ";
	   	$number_children_created = 0;

		foreach($this->ChildFirstName as $key => $c)
		{
			$children_information_query .= "('".$c."', '".$this->ChildLastName[$key]."', '".$this->School."', '".$this->ChildClass[$key]."'), ";
			$number_children_created++;
		}

		$children_information_query = rtrim($children_information_query,', ').";";
	   	$statement = $conn->prepare($children_information_query);
	   	$statement->execute();
	   	$child_last_created_id = $conn->lastInsertId();

	   	$number_children_created_array = Array();
		for ($i = 0; $i < $number_children_created; ++$i) {
			$created_child_id = $child_last_created_id+$i;
			array_push($number_children_created_array, $created_child_id);
		}

	   	$children_link_query = "INSERT INTO tbl_user_child(fk_child_id, fk_user_id) VALUES ";

		foreach($this->ChildFirstName as $key => $c)
		{
			$children_link_query .= "('".$number_children_created_array[$key]."', '".$this->UserId."'), ";
		}

		$children_link_query = rtrim($children_link_query,', ').";";
	   	$statement = $conn->prepare($children_link_query);
	   	$statement->execute();

	   	echo $children_link_query;
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