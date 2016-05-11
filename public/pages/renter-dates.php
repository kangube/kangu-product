<?php
    header('Content-Type: application/json');

	$db_username = 'root';
	$db_password = 'root';
	$db_name = 'kangu-product';
	$db_host = 'localhost';

	$mysqli_connection = new mysqli($db_host, $db_username, $db_password, $db_name);
	if ($mysqli_connection->connect_error) {
	    die('Error : ('. $mysqli_connection->connect_errno .') '. $mysqli_connection->connect_error);
	}

	$results = $mysqli_connection->query("SELECT booking_date_format FROM tbl_booking_dates LEFT JOIN tbl_booking ON tbl_booking_dates.fk_booking_id=tbl_booking.booking_id WHERE fk_renter_user_id=".$_GET['id']."");
	$datesArray = array();
    while($row = $results->fetch_array(MYSQLI_ASSOC)) {
        $datesArray[] = $row;
    }
    echo json_encode($datesArray);
?>