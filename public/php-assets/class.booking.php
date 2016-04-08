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

			case 'Booking_Extra_Information':
				return $this->m_sBooking_Extra_Information;
				break;
		}
	}
	
	public function Save() {
		$conn = Db::getInstance();
		$statement = $conn->prepare("INSERT INTO tbl_booking(
			fk_advert_id,
			fk_booker_user_id,
			fk_renter_user_id, 
			booking_extra_information,
			booking_price,
			booking_number_spots)
			VALUES 
			(:advertID, :bookerID, :renterID, :extrainformation, :booking_price, :booking_number_spots)");
		$statement->bindValue(
			':advertID', $this->Advert_ID);
		$statement->bindValue(
			':bookerID', $this->Booker_user_ID);
		$statement->bindValue(
			':renterID', $this->Renter_user_ID);
		$statement->bindValue(
			':extrainformation', $this->Booking_Extra_Information);
		$statement->bindValue(
			':booking_price', $this->Booking_Price);
		$statement->bindValue(
			':booking_number_spots', $this->Booking_Number_Spots);
		$statement->execute();
	}
	
}
?>