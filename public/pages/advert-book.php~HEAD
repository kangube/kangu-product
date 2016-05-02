<?php 
	include_once("../php-assets/class.advert.php");
	require_once("../php-assets/class.session.php");
	require_once("../php-assets/class.user.php");
	require_once("../php-assets/class.booking.php");

	$auth_user = new USER();
	$user_id = $_SESSION['user_session'];
	$stmt = $auth_user->runQuery("SELECT * FROM tbl_user WHERE user_id=:user_id");
	$stmt->execute(array(":user_id"=>$user_id));
	$userRow=$stmt->fetch(PDO::FETCH_ASSOC);

	$advert = new Advert();
	$oneAdvert = $advert->getOne();
	$oneDate = $advert->getOneDate();
	$oneService = $advert->getOneService();

	$booking = new Booking();

	$advertNumber = $_GET['id'];

	if(!empty($_POST))
	{
		try 
		{	
			// Calculating the booking price based on the chosen services
			$prices = array(
				'opvang-thuisomgeving' => 3,
				'ophalen-schoolpoort' => 2,
				'vervoer-thuis' => 2,
				'vervoer-naschoolse-activiteiten' => 2,
				'voorzien-maaltijd' => 1,
				'hulp-huiswerktaken' => 2
			);

			$services = $_POST['advert-booking-services'];
			$booking_price = 0;
			foreach(array_unique($services) as $key => $service) {
				if (!isset($prices[$service])) {
					continue;
				}
				$booking_price += $prices[$service];
			}

			// Passing data to the booking class for processing
			$booking->Advert_ID = $_POST['Advert_ID'];
			$booking->Booker_user_ID = $_POST['Booker_user_ID'];
			$booking->Renter_user_ID = $_POST['Renter_user_ID'];
			$booking->Booking_Number_Spots = $_POST['Booking_Number_Spots'];
			$booking->Booking_Price = $booking_price;
			$booking->Booking_Extra_Information = $_POST['Booking_Extra_Information'];
			
			$booking->Save();


			/*$originalDate = mysql_real_escape_string($_POST['Booking_Date']);
			$newDate = date("Y-m-d", strtotime($originalDate));
			$booking->Booking_Date = $newDate;
			
			$booking->SaveDate();
			$booking->updateAdvertNumberBookings();
			$booking->updateAvailabilitySpots();*/
			

			$succes = "Thank you for booking!";
		}
		catch(Exception $e)
		{
			$error = $e->getMessage();
		}
	}

	if(!empty($_POST))
	{
		$post_results = $mysqli->prepare("SELECT booking_id, booking_extra_information FROM tbl_booking WHERE 
			fk_advert_id = ".$_POST['Advert_ID']." 
			AND fk_booker_user_id = ".$_POST['Booker_user_ID']." 
			AND fk_renter_user_id = ".$_POST['Renter_user_ID']." 
			AND booking_number_spots = ".$_POST['Booking_Number_Spots']."  
			AND booking_extra_information = '".$_POST['Booking_Extra_Information']."'"
			);
		$post_results->execute();
		$post_results->bind_result($booking_id, $booking_information);

		while($post_results->fetch()) 
		{
			$originalDate = mysql_real_escape_string($_POST['Booking_Date']);
			$newDate = date("Y-m-d", strtotime($originalDate));
			$booking->Booking_Date = $newDate;
			$booking->Fk_Booking_ID = $booking_id;
			
			$booking->SaveDate();
		}
	}
?>
<!doctype html>
<html class="no-js" lang="nl">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Advertentie-overzicht</title>
        <link rel="stylesheet" href="../css/minimum-viable-product.min.css">
        <link href="https://file.myfontastic.com/QxAJVhmfbQ2t7NGCUAnz9P/icons.css" rel="stylesheet">
    </head>

	<body>
		<?php include('../php-includes/navigation.php'); ?>

		<div class="row">
			<div class="small-12 columns booking-create-form-container">
			  	<form method="post" data-abide novalidate>
				  	<p>
				  		<?php
							while($advert = $oneAdvert->fetch(PDO::FETCH_ASSOC))
							{
								echo "<h3>Info over advert van ".$advert["user_firstname"]."</h3>";
								echo "Advert creator: ".$advert["user_firstname"].' '.$advert["user_lastname"]."<br />";
								echo "Advert location: ".$advert["user_adress"].', '.$advert["user_city"]."<br />";
								echo "Contact email: ".$advert["user_email"]."<br />";
								echo "Contact home number: ".$advert["user_home_number"]."<br />";
								echo "Contact mobile number: ".$advert["user_mobile_number"]."<br />";
								echo "Description: ".$advert["advert_description"]."<br />";
								echo "Price: ".$advert["advert_price"]."<br />";
								echo "Spots left: ".$advert["advert_spots"]."<br />";
								echo "Advert school: ".$advert["advert_school"]."<br />";
								echo "Advert transport: ".$advert["advert_transport"]."<br />";
								echo "<br/>";
								
								echo '<input type="hidden" id="ID" name="Advert_ID" value="'.$advert["advert_id"].'"/>';
								echo '<input type="hidden" id="ID" name="Booker_user_ID" value="'.$advert["user_id"].'"/>';	
								echo '<input type="hidden" id="ID" name="Renter_user_ID" value="'.$userRow['user_id'].'"/>';		
							}
						?>
				  	</p>

					<?php if(isset($error)): ?>
						<div class="error">
							<?php echo $error;?>
						</div>
					<?php endif; ?>

					<?php if(isset($succes)): ?>
						<div class="feedback">
							<?php echo $succes;?>
						</div>
					<?php endif; ?>

					<div class="availability-events"></div>
					
					<label for="children">Aantal kinderen dat je wilt boeken</label>
					
					<select name="Booking_Number_Spots">
					<?php
						$advertspots_results = $mysqli->prepare("SELECT availability_spots FROM tbl_availability LEFT JOIN tbl_advert ON tbl_advert.advert_id=tbl_availability.fk_advert_id WHERE tbl_advert.advert_id = ".$_GET['id']."");
						$advertspots_results->execute();
						$advertspots_results->bind_result($availability_spots);

						while($advertspots_results->fetch()) 
						{
							if ($availability_spots == 1) {
					  					echo '<option value="1" selected>1 kind</option>';
							}elseif ($availability_spots == 2) {
					  					echo '<option value="1" selected>1 kind</option>';
					  					echo '<option value="2">2 kinderen</option>';
							}elseif ($availability_spots == 3) {
					  					echo '<option value="1" selected>1 kind</option>';
					  					echo '<option value="2">2 kinderen</option>';
					  					echo '<option value="3">3 kinderen</option>';
							}
							elseif ($availability_spots == 4) {
					  					echo '<option value="1" selected>1 kind</option>';
					  					echo '<option value="2">2 kinderen</option>';
					  					echo '<option value="3">3 kinderen</option>';
					  					echo '<option value="4">4 kinderen</option>';
							}
						}
					?>
					</select>

					<br/>
					<br/>

					<label for="info">Vink de services aan die je wil gebruiken</label><br/>
					<input type="hidden" name="advert-booking-services[]" value="opvang-thuisomgeving">
					<input type="hidden" name="advert-booking-services[]" value="ophalen-schoolpoort">

					<?php
						while($service = $oneService->fetch(PDO::FETCH_ASSOC))
						{
							if (($service["service_name"] == 'opvang-thuisomgeving')OR($service["service_name"] == 'ophalen-schoolpoort'))
							{
								echo '<input class="my-activity" type="checkbox" name="advert-booking-services[]" value='.$service["service_name"].' disabled checked>'.$service["service_name"].'<br/>';
							}
							else 
							{
								echo '<input class="my-activity" type="checkbox" name="advert-booking-services[]" value='.$service["service_name"].'>'.$service["service_name"].'<br/>';
							}
						}
					?>
					
					<label for="info">Extra informatie</label><br/>
					<textarea id="info" name="Booking_Extra_Information"></textarea>
				
					<input class="submit" type="submit" id="btnSubmit" value="Book" />
				</form>
			</div>
		</div>

		<?php include('../php-includes/footer.php'); ?>

		<script src="../js/minimum-viable-product.min.js"></script>
	    <script src="https://use.typekit.net/vnw3zje.js"></script>
	    <script>try{Typekit.load({ async: true });}catch(e){}</script>
	    
		<script>
			$(document).ready(function() {
				var getUrlParameter = function getUrlParameter(sParam) {
				    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
				        sURLVariables = sPageURL.split('&'),
				        sParameterName,
				        i;

				    for (i = 0; i < sURLVariables.length; i++) {
				        sParameterName = sURLVariables[i].split('=');

				        if (sParameterName[0] === sParam) {
				            return sParameterName[1] === undefined ? true : sParameterName[1];
				        }
				    }
				};

				var advert_id = getUrlParameter('id');

				if (typeof advert_id !== 'undefined') {
	                var Event = function(className) {
				    	this.className = className;
					};

					var events = [];
					$.getJSON('availability-dates.php?id="'+advert_id+'"', function(data) {
	                    $.each(data, function(key, val) {
	                        availability_date_item = val.availability_date.replace(/-/g, '/');
	                        events[new Date(availability_date_item)] = new Event("availability-date-item");
	                    });
	                });

					$('.availability-events').datepicker({
				        inline: true,
					    firstDay: 0,
					    showOtherMonths: true,
					    monthNames: ['Januari', 'Februari', 'Maart', 'April', 'Mei', 'Juni', 'Juli', 'Augustus', 'September', 'Oktober', 'November', 'December'],
					    dayNames: ['Zondag', 'Maandag', 'Dinsdag', 'Woensdag', 'Donderdag', 'Vrijdag', 'Zaterdag'],
					    dayNamesMin: ['Zo', 'Ma', 'Di', 'Wo', 'Do', 'Vr', 'Za'],
					    beforeShowDay: function(date) {
					        var event = events[date];

					        if (event) {
					            return [true, event.className];
					        }
					        else {
					            return [true, ''];
					        }
					    }
					});
				}
			});
		</script>
	</body>
</html>