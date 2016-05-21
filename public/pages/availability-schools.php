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

	$results = $mysqli_connection->query("SELECT school_name from tbl_school ORDER BY school_name");

	$schoolsArray = array();
    while($row = $results->fetch_array(MYSQLI_ASSOC)) {
        $schoolsArray[] = $row;
    }

    echo json_encode($schoolsArray);
?>