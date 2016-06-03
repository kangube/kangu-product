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
			// Gather all corresponding data from the chosen advert
			while($advert = $oneAdvert->fetch(PDO::FETCH_ASSOC)) {
				$advert_id = $advert['advert_id'];
				$advert_user_id = $advert['user_id'];
			}

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
			$booking->Advert_ID = $advert_id;
			$booking->Booker_user_ID = $advert_user_id;
			$booking->Renter_user_ID = $userRow['user_id'];
			$booking->Booking_Number_Spots = $_POST['booking_number_children'];
			$booking->Booking_Price = $booking_price;
			$booking->Booking_Extra_Information = $_POST['booking_extra_information'];
			
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
			fk_advert_id = ".$advert_id." 
			AND fk_booker_user_id = ".$advert_user_id." 
			AND fk_renter_user_id = ".$userRow['user_id']." 
			AND booking_number_spots = ".$_POST['booking_number_children']."  
			AND booking_extra_information = '".$_POST['booking_extra_information']."'"
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

		<div class="full-width-advert-book">
			<div class="full-height-gradient"></div>

			<div class="advert-book-create-container">
				<div class="advert-book-form-container">
				  	<form class="advert-book-form" method="post" data-abide novalidate>

				  		<div class="form-select-date-container">
				  			<h3 class="form-header">Opvang-datum</h3>
							<hr class='blue-horizontal-line'></hr>
							<p class="form-subheader">Selecteer de datum waarvoor u graag opvang zou willen aanvragen.</p>
							<div class="availability-spots-select"></div>
						</div>

						<div class='form-select-children-container'>
							<h3 class="form-header">Aantal kinderen</h3>
							<hr class='blue-horizontal-line'></hr>
							<p class="form-subheader">Selecteer de kinderen die moeten opgevangen worden zodat de opvang-ouder weet welke kinderen men moet ophalen en opvangen.</p>

							<?php
								$check_user_has_provided_children = $auth_user->hasProvidedChildren($userRow['user_id']);
								if($check_user_has_provided_children) {
									echo '<p>This user has provided us with the right information about his/her children!</p>';
								}
								else {
									echo '<div class="number-children-container">
											<div class="form-icon-input-field">
												<div class="form-icon-input-container">
													<span class="form-icon" data-icon="o"></span>
													<input class="form-input" type="text" name="advert-child-name[]" placeholder="Voor- en achternaam van jouw kind" required>
												</div>
											</div>

											<div class="form-icon-input-field">
												<div class="form-icon-input-container">
													<span class="form-icon" data-icon="e"></span>
													<input class="form-input" type="text" name="advert-child-class[]" placeholder="Klasnummer van jouw kind" required>
												</div>
											</div>
										</div>

										<a class="advert-add-child-button">Kind toevoegen</a>';
								}
							?>
						</div>

						<div class="form-select-transportation-container">
							<h3 class="form-header">Verplaatsingsmogelijkheden</h3>
							<hr class="blue-horizontal-line"></hr>
							<p class="form-subheader">Geef aan op welke manier(en) je de kinderen van en naar school voert. (Meerdere opties zijn mogelijk)</p>

							<div class="show-for-large transportation-container">
								<div class="transportation">
									<ul>
										<li>
											<div class="checkbox">
												<input type="checkbox" name="advert-transportation[]" id="auto" value="auto">
												<label for="auto"><span></span>Met de auto</label>
			  								</div>
			  							</li>

			  							<li>
			  								<div class="checkbox">
				  								<input type="checkbox" name="advert-transportation[]" id="fiets" value="fiets">
		  										<label for="fiets"><span></span>Met de fiets</label>
			  								</div>
			  							</li>
									</ul>
								</div>

								<div class="vertical-line"></div>

								<div class="transportation">
									<ul>
										<li>
			  								<div class="checkbox">
				  								<input type="checkbox" name="advert-transportation[]" id="openbaar-vervoer" value="openbaar-vervoer">
		  										<label for="openbaar-vervoer"><span></span>Openbaar vervoer</label>
			  								</div>
			  							</li>

			  							<li>
			  								<div class="checkbox">
				  								<input type="checkbox" name="advert-transportation[]" id="wandelend" value="wandelend">
		  										<label for="wandelend"><span></span>Te voet</label>
			  								</div>
			  							</li>
									</ul>
								</div>
							</div>

							<div class="show-for-small hide-for-large transportation-container-mobile">
								<ul>
									<li>
										<div class="checkbox">
											<input type="checkbox" name="advert-transportation[]" id="auto-mobile" value="auto">
											<label for="auto-mobile"><span></span>Met de auto</label>
		  								</div>
		  							</li>

		  							<li>
		  								<div class="checkbox">
			  								<input type="checkbox" name="advert-transportation[]" id="openbaar-vervoer-mobile" value="openbaar-vervoer">
	  										<label for="openbaar-vervoer-mobile"><span></span>Openbaar vervoer</label>
		  								</div>
		  							</li>

		  							<li>
		  								<div class="checkbox">
			  								<input type="checkbox" name="advert-transportation[]" id="fiets-mobile" value="fiets">
	  										<label for="fiets-mobile"><span></span>Met de fiets</label>
		  								</div>
		  							</li>

		  							<li>
		  								<div class="checkbox">
			  								<input type="checkbox" name="advert-transportation[]" id="wandelend-mobile" value="wandelend">
	  										<label for="wandelend-mobile"><span></span>Te voet</label>
		  								</div>
		  							</li>
								</ul>
							</div>
						</div>

						<div class="form-select-services-container">
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
						</div>
						
						<div class="form-add-extra-information-container">
							<h3 class="form-header">Extra informatie</h3>
							<hr class='blue-horizontal-line'></hr>
							<textarea id="info" name="booking_extra_information" placeholder="Geef hier eventuele extra informatie mee waarvan de opvang-ouder dient op de hoogte gebracht te worden." rows="5" cols="10"></textarea>
						</div>

						<div class="form-submit-request-container">
							<input class="submit" type="submit" id="btnSubmit" value="Opvang-aanvraag versturen"/>
						</div>
					</form>
				</div>
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

	                $(document).ready(function() {
				    	checkSize();
					    $(window).resize(checkSize);

						function checkSize() {
							var currentSize = Foundation.MediaQuery.current;
							var numberOfMonths = $('.availability-spots-select').datepicker('option', 'numberOfMonths');
						    if (currentSize == 'small' || currentSize == 'medium') {
								$('.availability-spots-select').datepicker('option', 'numberOfMonths', 1);
							}
							else if (currentSize == 'large' || currentSize == 'xlarge' || currentSize == 'xxlarge') {
								$('.availability-spots-select').datepicker('option', 'numberOfMonths', [1,2]);
							}
						}
					});

					$('.availability-spots-select').datepicker({
				        inline: true,
					    dateFormat: 'yy-mm-dd',
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
					            return [false, ''];
					        }
					    },
					    onSelect: function(date) {
							$.getJSON('availability-spots.php?id='+advert_id+'&date='+date+'', function(data) {
			                    $.each(data, function(key, val) {
			                    	if (val.availability_spots == 1) {
			                    		$('.select-children-alert').html('Er is nog '+val.availability_spots+' beschikbare plaats');
			                    	}
			                    	else if (val.availability_spots >= 1) {
			                    		$('.select-children-alert').html('Er zijn nog '+val.availability_spots+' beschikbare plaatsen');
			                    	}
			                    });
			                });

			                $('.form-select-children-container').css('display', 'block');
						}
					});
				}
			});
		</script>
	</body>
</html>