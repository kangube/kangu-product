<?php

require_once('class.dbconfig.php');

class Booking
{	
	private $m_iAdvertId;
	private $m_iBookerUserId;
	private $m_iRenterUserId;
	private $m_iNumberSpots;
	private $m_iPrice;
	private $m_sExtraInformation;
	private $m_sDate;
	private $m_iChildId;
	private $m_sServiceId;

	private $conn;
	
	public function __construct() {
		$database = new Database();
		$db = $database->dbConnection();
		$this->conn = $db;
    }

    public function __set($p_sProperty, $p_sValue) {
		switch ($p_sProperty) 
		{
			case 'AdvertId':
				$this->m_iAdvertId = $p_sValue;
				break;

			case 'BookerUserId':
				$this->m_iBookerUserId = $p_sValue;
				break;

			case 'RenterUserId':
				$this->m_iRenterUserId = $p_sValue;
				break;

			case 'NumberSpots':
				$this->m_iNumberSpots = $p_sValue;
				break;

			case 'Price':
				$this->m_iPrice = $p_sValue;
				break;

			case 'ExtraInformation':
				$this->m_sExtraInformation = $p_sValue;
				break;

			case 'Date':
				$this->m_sDate = $p_sValue;
				break;

			case 'ChildId':
				$this->m_iChildId = $p_sValue;
				break;

			case 'ServiceId':
				$this->m_sServiceId = $p_sValue;
				break;
		}
	}

	public function __get($p_sProperty) {
		switch ($p_sProperty) 
		{
			case 'AdvertId':
				return $this->m_iAdvertId;
				break;

			case 'BookerUserId':
				return $this->m_iBookerUserId;
				break;

			case 'RenterUserId':
				return $this->m_iRenterUserId;
				break;

			case 'NumberSpots':
				return $this->m_iNumberSpots;
				break;

			case 'Price':
				return $this->m_iPrice;
				break;

			case 'ExtraInformation':
				return $this->m_sExtraInformation;
				break;

			case 'Date':
				return $this->m_sDate;
				break;

			case 'ChildId':
				return $this->m_iChildId;
				break;

			case 'ServiceId':
				return $this->m_sServiceId;
				break;
		}
	}
	
	public function Save() {
		$conn = Db::getInstance();

		// Creating a new booking with all of the chosen data
		$statement = $conn->prepare("INSERT INTO tbl_booking(fk_advert_id, fk_booker_user_id, fk_renter_user_id, booking_number_spots, booking_price, booking_extra_information, booking_status) VALUES (:AdvertId, :BookerUserId, :RenterUserId, :NumberSpots, :Price, :ExtraInformation, 'pending')");
		$statement->bindValue(':AdvertId', $this->AdvertId);
		$statement->bindValue(':BookerUserId', $this->BookerUserId);
		$statement->bindValue(':RenterUserId', $this->RenterUserId);
		$statement->bindValue(':NumberSpots', $this->NumberSpots);
		$statement->bindValue(':Price', $this->Price);
		$statement->bindValue(':ExtraInformation', $this->ExtraInformation);
		$statement->execute();

		// Retrieving the last created booking_id and saving the booked date related to the newly created booking
		$last_created_booking_id = $conn->lastInsertId();

		$statement = $conn->prepare("INSERT INTO tbl_booking_date(fk_booking_id, booking_date_format) VALUES (:BookingId, :BookingDate)");
		$statement->bindValue(':BookingId', $last_created_booking_id);
		$statement->bindValue(':BookingDate', $this->Date);
		$statement->execute();

		// Saving all of chosen children related to the newly created booking
		$selected_children_query = "INSERT INTO tbl_booking_child(fk_booking_id, fk_child_id) VALUES ";
		$selected_children_iterator = new ArrayIterator($this->ChildId);
		$selected_children_cachingiterator = new CachingIterator($selected_children_iterator);

		foreach ($selected_children_cachingiterator as $value)
	    {
	        $selected_children_query .= "($last_created_booking_id, ".$selected_children_cachingiterator->current().")";

	        if($selected_children_cachingiterator->hasNext())
	        {
	            $selected_children_query .= ", ";
	        }
	    }

	    $statement = $conn->prepare($selected_children_query);
		$statement->execute();

		// Saving all of the chosen services related to the newly created booking
		$selected_services_query = "INSERT INTO tbl_booking_service(fk_booking_id, fk_service_id) VALUES ";
		$selected_services_iterator = new ArrayIterator($this->ServiceId);
		$selected_services_cachingiterator = new CachingIterator($selected_services_iterator);

		foreach ($selected_services_cachingiterator as $value)
	    {
	        $selected_services_query .= "($last_created_booking_id, ".$selected_services_cachingiterator->current().")";

	        if($selected_services_cachingiterator->hasNext())
	        {
	            $selected_services_query .= ", ";
	        }
	    }

		$statement = $conn->prepare($selected_services_query);
		$statement->execute();
	}

	public function UpdateAdvertNumberBookings() {
		$conn = Db::getInstance();
		$statement = $conn->prepare("UPDATE tbl_advert SET advert_number_bookings = (advert_number_bookings + :NumberSpots) WHERE advert_id = :AdvertId");
		$statement->bindValue(':AdvertId', $this->AdvertId);
		$statement->bindValue(':NumberSpots', $this->NumberSpots);
		$statement->execute();
	}

	public function UpdateAvailabilitySpots() {
		$conn = Db::getInstance();
		$statement = $conn->prepare("UPDATE tbl_availability SET availability_spots = (availability_spots - :NumberSpots) WHERE fk_advert_id = :AdvertId AND availability_date = :BookingDate");
		$statement->bindValue(':AdvertId', $this->AdvertId);
		$statement->bindValue(':NumberSpots', $this->NumberSpots);
		$statement->bindValue(':BookingDate', $this->Date);
		$statement->execute();
	}
}
?>