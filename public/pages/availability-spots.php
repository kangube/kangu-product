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

	$results = $mysqli_connection->query("SELECT availability_spots FROM tbl_availability LEFT JOIN tbl_advert ON tbl_advert.advert_id=tbl_availability.fk_advert_id WHERE tbl_availability.fk_advert_id='".$_GET['id']."' AND tbl_availability.availability_date='".$_GET['date']."'");

	$spotsArray = array();
    while($row = $results->fetch_array(MYSQLI_ASSOC)) {
        $spotsArray[] = $row;
    }

    echo json_encode($spotsArray);
?>