<?php
	header('Content-Type: application/json');

	include("../php-assets/class.dbconfig.php");

	$conn = Db::getInstance();

	$results = $conn->prepare("SELECT * FROM tbl_availability WHERE fk_advert_id=".$_GET['id']."");
	$results->execute();

	$datesArray = array();
    while($row = $results->fetch(PDO::FETCH_ASSOC)) {
        $datesArray[] = $row;
    }

    echo json_encode($datesArray);
?>