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

	$results = $mysqli_connection->query("SELECT availability_date from tbl_availability WHERE fk_advert_id=".$_GET['id']."");

	$datesArray = array();
    while($row = $results->fetch_array(MYSQLI_ASSOC)) {
        $datesArray[] = $row;
    }

    echo json_encode($datesArray);
?>