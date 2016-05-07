<?php 
	
	include_once("../php-assets/class.advert.php");
	require_once("../php-assets/class.session.php");
	require_once("../php-assets/class.user.php");

	$auth_user = new USER();
	$user_id = $_SESSION['user_session'];
	$stmt = $auth_user->runQuery("SELECT * FROM tbl_user WHERE user_id=:user_id");
	$stmt->execute(array(":user_id"=>$user_id));
	$userRow=$stmt->fetch(PDO::FETCH_ASSOC);

?><!doctype html>
<html class="no-js" lang="nl">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Advertentie-overzicht</title>
        <link rel="stylesheet" href="../css/minimum-viable-product.min.css">
        <link href="https://file.myfontastic.com/QxAJVhmfbQ2t7NGCUAnz9P/icons.css" rel="stylesheet">
    </head>

	<body>	
		<?php include('../php-includes/navigation.php'); ?>
	
		<div class="large-12 columns datepicker-small">
		    	<h2 class="mrgtop">Boekingen</h2>
		    	<br/>
		    	<h3>Advertenties die ik geboekt heb</h3>
		    	<?php

					$advert_results = $mysqli->prepare("SELECT COUNT(tbl_booking.booking_id), tbl_booking.booking_id, tbl_booking.fk_advert_id, tbl_booking.fk_booker_user_id, tbl_booking.fk_renter_user_id, tbl_booking.booking_number_spots, tbl_booking.booking_price, tbl_booking.booking_extra_information FROM tbl_booking WHERE tbl_booking.fk_renter_user_id = ".$userRow['user_id']."");
					$advert_results->execute();
					$advert_results->bind_result($COUNT, $booking_id, $fk_advert_id, $fk_booker_user_id, $fk_renter_user_id, $booking_number_spots, $booking_price, $booking_extra_information);

					while($advert_results->fetch()) 
					{
						echo "Advertentie geboekt: #".$fk_advert_id."<br/>";
					}

				?>
				<br/>
		    	<h3>Mijn advertentie is geboekt door</h3>
		    	<?php
					$advert_results = $mysqli->prepare("SELECT tbl_booking.booking_id, tbl_booking.fk_advert_id, tbl_booking.fk_booker_user_id, tbl_booking.fk_renter_user_id, tbl_booking.booking_number_spots, tbl_booking.booking_price, tbl_booking.booking_extra_information FROM tbl_booking WHERE tbl_booking.fk_booker_user_id = ".$userRow['user_id']."");
					$advert_results->execute();
					$advert_results->bind_result($booking_id, $fk_advert_id, $fk_booker_user_id, $fk_renter_user_id, $booking_number_spots, $booking_price, $booking_extra_information);

					while($advert_results->fetch()) 
					{
						echo "Mijn advertentie is geboekt door: User ".$fk_renter_user_id."<br/>";
					}
				?>
		</div>
		
		<div class="large-12 columns datepicker-small">
		    	<h2 class="mrgtop">Datums van boekingen</h2>
		    	<br/>
		    	<h3>Datums waarop ik anderen geboekt heb</h3>
				<?php
					//Datums formatteren om te tonen in agenda, waarop ik anderen geboekt heb
					$bookingdate_results = $mysqli->prepare("SELECT fk_booking_id, booking_date_format FROM tbl_booking_dates LEFT JOIN tbl_booking ON tbl_booking_dates.fk_booking_id=tbl_booking.booking_id WHERE tbl_booking.fk_renter_user_id = ".$userRow['user_id']."");
					$bookingdate_results->execute();
					$bookingdate_results->bind_result($fk_booking_id, $booking_date_format);

						while($bookingdate_results->fetch()) 
						{	
							//echo "Datums die bij advertentie horen: ".$availability_date;
							$originalDate = $booking_date_format;
							//$sign = ', ';
							$newDateBooking = date("m/d/Y", strtotime($originalDate));	
							//echo "<br/>Geformatteerde datum: ".$newDate;
							//echo $newDateBooking;
						}

					//Datums tonen waarop ik anderen geboekt heb
					$booking_results = $mysqli->prepare("SELECT fk_booking_id, booking_date_format FROM tbl_booking_dates LEFT JOIN tbl_booking ON tbl_booking_dates.fk_booking_id=tbl_booking.booking_id WHERE tbl_booking.fk_renter_user_id = ".$userRow['user_id']."");
					$booking_results->execute();
					$booking_results->bind_result($fk_booking_id, $booking_date_format);

					while($booking_results->fetch()) 
					{
						echo "Datum: ".$booking_date_format."<br/>";
					}
				?>
				<br/>
		    	<h3>Datums waarop ik geboekt ben</h3>
				<?php
					//Datums formatteren om te tonen in agenda, waarop ik geboekt ben
					$bookingdate_results = $mysqli->prepare("SELECT COUNT(fk_booking_id), fk_booking_id, booking_date_format FROM tbl_booking_dates LEFT JOIN tbl_booking ON tbl_booking_dates.fk_booking_id=tbl_booking.booking_id WHERE tbl_booking.fk_booker_user_id = ".$userRow['user_id']."");
					$bookingdate_results->execute();
					$bookingdate_results->bind_result($count, $fk_booking_id, $booking_date_format);
						
							while($bookingdate_results->fetch()) 
							{
								$originalDate = $booking_date_format;
								$newDateBooked = date("m/d/Y", strtotime($originalDate));
							}
						
					//Datums tonen waarop ik geboekt ben
					$booked_results = $mysqli->prepare("SELECT fk_booking_id, booking_date_format FROM tbl_booking_dates LEFT JOIN tbl_booking ON tbl_booking_dates.fk_booking_id=tbl_booking.booking_id WHERE tbl_booking.fk_booker_user_id = ".$userRow['user_id']."");
					$booked_results->execute();
					$booked_results->bind_result($fk_booking_id, $booking_date_format);

					while($booked_results->fetch()) 
					{
						echo "Datum: ".$booking_date_format."<br/>";
					}
				?>
		</div>

	    <div class="large-6 columns datepicker-small">
		    	<h2 class="mrgtop">Dagen waarop ik geboekt ben</h2>
		    	<hr class="blue-horizontal-line"></hr>

				<div id="planning-events"></div>
		</div>

</body>
</html>

<script src="http://multidatespickr.sourceforge.net/jquery-ui.multidatespicker.js"></script>
<script src="../js/minimum-viable-product.min.js"></script>