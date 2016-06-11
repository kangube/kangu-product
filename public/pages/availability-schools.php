<?php
	include("../php-assets/class.dbconfig.php");

	$conn = Db::getInstance();

	header('Content-Type: application/json');

	$results = $conn->prepare("SELECT school_name from tbl_school ORDER BY school_name");
	$results->execute();

	$schoolsArray = array();
    while($row = $results->fetch(PDO::FETCH_ASSOC)) {
        $schoolsArray[] = $row;
    }

    echo json_encode($schoolsArray);
?>