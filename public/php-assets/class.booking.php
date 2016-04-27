<?php

require_once('class.dbconfig.php');

class booking
{	
	private $m_sAdvert_ID;
	private $m_sBooker_user_ID;
	private $m_sRenter_user_ID;
	private $m_sBooking_Number_Spots;
	private $m_sBooking_Price;
	private $m_sBooking_Extra_Information;
	private $m_sBooking_Date;
	private $m_sFk_Booking_ID;
	private $conn;
	
	public function __construct() {
		$database = new Database();
		$db = $database->dbConnection();
		$this->conn = $db;
    }

    public function __set($p_sProperty, $p_sValue) {
		switch ($p_sProperty) 
		{
			case 'Advert_ID':
				$this->m_sAdvert_ID = $p_sValue;
				break;

			case 'Booker_user_ID':
				$this->m_sBooker_user_ID = $p_sValue;
				break;

			case 'Renter_user_ID':
				$this->m_sRenter_user_ID = $p_sValue;
				break;

			case 'Booking_Number_Spots':
				$this->m_sBooking_Number_Spots = $p_sValue;
				break;

			case 'Booking_Price':
				$this->m_sBooking_Price = $p_sValue;
				break;

			case 'Booking_Date':
				$this->m_sBooking_Date = $p_sValue;
				break;

			case 'Fk_Booking_ID':
				$this->m_sFk_Booking_ID = $p_sValue;
				break;

			case 'Booking_Extra_Information':
				$this->m_sBooking_Extra_Information = $p_sValue;
				break;
		}
	}

	public function __get($p_sProperty) {
		switch ($p_sProperty) 
		{
			case 'Advert_ID':
				return $this->m_sAdvert_ID;
				break;

			case 'Booker_user_ID':
				return $this->m_sBooker_user_ID;
				break;

			case 'Renter_user_ID':
				return $this->m_sRenter_user_ID;
				break;

			case 'Booking_Number_Spots':
				return $this->m_sBooking_Number_Spots;
				break;

			case 'Booking_Price':
				return $this->m_sBooking_Price;
				break;

			case 'Booking_Date':
				return $this->m_sBooking_Date;
				break;

			case 'Fk_Booking_ID':
				return $this->m_sFk_Booking_ID;
				break;

			case 'Booking_Extra_Information':
				return $this->m_sBooking_Extra_Information;
				break;
		}
	}
	
	public function Save() {
		$conn = Db::getInstance();
		$statement = $conn->prepare("INSERT INTO tbl_booking(fk_advert_id, fk_booker_user_id, fk_renter_user_id, booking_extra_information, booking_price, booking_number_spots) VALUES ('$this->Advert_ID', '$this->Booker_user_ID', '$this->Renter_user_ID', '$this->Booking_Extra_Information', '$this->Booking_Price', '$this->Booking_Number_Spots')");
		//$statement->execute();
		echo "INSERT INTO tbl_booking(fk_advert_id, fk_booker_user_id, fk_renter_user_id, booking_extra_information, booking_price, booking_number_spots) VALUES ('$this->Advert_ID', '$this->Booker_user_ID', '$this->Renter_user_ID', '$this->Booking_Extra_Information', '$this->Booking_Price', '$this->Booking_Number_Spots')";
	}

	public function SaveDate() {
		$conn = Db::getInstance();
		$statement = $conn->prepare("INSERT INTO tbl_booking_dates(
			booking_date_format,
			fk_booking_id
			)
			VALUES 
			(:booking_date, :fk_booking_id)");
		$statement->bindValue(
			':booking_date', $this->Booking_Date);
		$statement->bindValue(
			':fk_booking_id', $this->Fk_Booking_ID);
		$statement->execute();
	}

	public function updateAdvertNumberBookings(){
		$conn = Db::getInstance();
		$statement = $conn->prepare("UPDATE tbl_advert SET advert_number_bookings = (advert_number_bookings + :spots) WHERE advert_id = :advertID");
		$statement->bindValue(
			':advertID', $this->Advert_ID);
		$statement->bindValue(
			':spots', $this->Booking_Number_Spots);
		$statement->execute();
	}

	public function updateAvailabilitySpots(){
		$conn = Db::getInstance();
		$statement = $conn->prepare("UPDATE tbl_availability SET availability_spots = (availability_spots - :spots) WHERE fk_advert_id = :advertID");
		$statement->bindValue(
			':advertID', $this->Advert_ID);
		$statement->bindValue(
			':spots', $this->Booking_Number_Spots);
		$statement->execute();
	}

}
?>