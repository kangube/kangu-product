<?php
	header('Content-Type: application/json');

	include("../php-assets/class.dbconfig.php");

	$conn = Db::getInstance();

	$results = $conn->prepare("SELECT availability_spots FROM tbl_availability LEFT JOIN tbl_advert ON tbl_advert.advert_id=tbl_availability.fk_advert_id WHERE tbl_availability.fk_advert_id='".$_GET['id']."' AND tbl_availability.availability_date='".$_GET['date']."'");
	$results->execute();

	$spotsArray = array();
    while($row = $results->fetch(PDO::FETCH_ASSOC)) {
        $spotsArray[] = $row;
    }

    echo json_encode($spotsArray);
?>