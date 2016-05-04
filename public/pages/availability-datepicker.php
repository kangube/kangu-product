<?php
	header('Content-Type: application/json');

	$results = $mysqli->query("SELECT availability_date from tbl_availability WHERE fk_advert_id=".$_GET['id']."");
​
	$datesArray = array();
    while($row = $results->fetch_array(MYSQLI_ASSOC)) {
        $datesArray[] = $row;
    }
​
    echo json_encode($datesArray);
?>	