<?php
	header('Content-Type: application/json');
							
	$db_username = 'root';
	$db_password = 'root';
	$db_name = 'kangu-product';
	$db_host = 'localhost';

	$conn = new mysqli($db_host, $db_username, $db_password, $db_name);
	if ($conn->connect_error) {
	    die('Error : ('. $conn->connect_errno .') '. $conn->connect_error);
	}

	$queryResults = $conn->query("SELECT booking_date_format, tbl_booking.fk_renter_user_id tbl_booking_dates LEFT JOIN tbl_booking ON tbl_booking_dates.fk_booking_id= tbl_booking.booking_id WHERE fk_renter_user_id=".$_GET['id']."");

	$bookingDatesArray = array();
    while($row = $queryResults->fetch_array(MYSQLI_ASSOC)) {
        $bookingDatesArray[] = $row;
    }

    echo json_encode($bookingDatesArray);
?>