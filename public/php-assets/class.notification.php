<?php

require_once('class.dbconfig.php');

class Notification
{	
	private $m_sNotificationID;
	private $m_sBookingID;

	private $conn;
	public function __construct() {
		$database = new Database();
		$db = $database->dbConnection();
		$this->conn = $db;
    }

    public function __set($p_sProperty, $p_sValue) {
		switch ($p_sProperty) 
		{
			case 'NotificationID':
				$this->m_sNotificationID = $p_sValue;
				break;

			case 'BookingID':
				$this->m_sBookingID = $p_sValue;
				break;

		}
	}

	public function __get($p_sProperty) {
		switch ($p_sProperty) 
		{
			case 'NotificationID':
				return $this->m_sNotificationID;
				break;

			case 'BookingID':
				return $this->m_sBookingID;
				break;

		}
	}

	public function DeleteNotification() {
		$conn = Db::getInstance();
		$statement = $conn->prepare("DELETE FROM tbl_notifications WHERE notification_id = :id");
		$statement->bindValue(':id', $this->NotificationID );
		$statement->execute();
	}

	public function ReadNotification() {
		$conn = Db::getInstance();
		$statement = $conn->prepare("UPDATE tbl_notifications SET notification_status = 'read' WHERE notification_id = :id");
		$statement->bindValue(':id', $this->NotificationID );
		$statement->execute();
	}

	public function AcceptBooking() {
		$conn = Db::getInstance();
		$statement = $conn->prepare("UPDATE tbl_booking SET booking_status = 'accepted' WHERE booking_id = :bookingid");
		$statement->bindValue(':bookingid', $this->BookingID );
		$statement->execute();
	}

	public function getAllNotifications() {
		$conn = Db::getInstance();
		$allNotifications = $conn->query("SELECT * FROM tbl_notifications LEFT JOIN tbl_booking ON tbl_notifications.notification_fk_booking_id = tbl_booking.booking_id ORDER BY `notification_date` ASC");
		return $allNotifications;
	}

}
?>