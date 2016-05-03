<?php
	include_once("../php-assets/class.advert.php");
	require_once("../php-assets/class.session.php");
	require_once("../php-assets/class.user.php");
	require_once("../php-assets/class.pagination-reviews.php");

	$auth_user = new USER();
	$user_id = $_SESSION['user_session'];
	$stmt = $auth_user->runQuery("SELECT * FROM tbl_user WHERE user_id=:user_id");
	$stmt->execute(array(":user_id"=>$user_id));
	$userRow=$stmt->fetch(PDO::FETCH_ASSOC);

	$advert = new Advert();
	$oneAdvert = $advert->getOne();
	$advert_information = $oneAdvert->fetch(PDO::FETCH_ASSOC);

	// Processing and creating the full adress for usage in the google maps api
	$advert_full_adress = $advert_information['user_adress'].','.$advert_information['user_city'];

	// Processing all of the provided services
	$db_username = 'root';
	$db_password = 'root';
	$db_name = 'kangu-product';
	$db_host = 'localhost';

	$mysqli_connection = new mysqli($db_host, $db_username, $db_password, $db_name);
	if ($mysqli_connection->connect_error) {
	    die('Error : ('. $mysqli_connection->connect_errno .') '. $mysqli_connection->connect_error);
	}

	$results = $mysqli_connection->query("SELECT service_name from tbl_service WHERE fk_advert_id=".$_GET['id']."");

	$services = array(
		'opvang-thuisomgeving',
		'ophalen-schoolpoort',
		'vervoer-thuis',
		'vervoer-naschoolse-activiteiten',
		'voorzien-maaltijd',
		'hulp-huiswerktaken'
	);

	$servicesArray = array();
    while($row = $results->fetch_array(MYSQLI_ASSOC)) {
        $servicesArray[] = $row['service_name'];
    }
?>

<!doctype html>
<html class="no-js" lang="nl">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Advertentie-detail</title>
        <link rel="stylesheet" href="../css/minimum-viable-product.min.css">
        <link href="https://file.myfontastic.com/wfY5TXHecmqLMkPUKHzNrK/icons.css" rel="stylesheet">
    </head>

	<body>
		<?php include('../php-includes/navigation.php'); ?>

		<div class="small-12 columns advert-detail-header">
	        <div class="advert-detail-title-container">
	        	<img src=<?php echo $advert_information['user_image_path']; ?> alt="profiel foto" />
	            <h1 class="advert-detail-title"><?php echo $advert_information["user_firstname"]." ".$advert_information["user_lastname"]; ?></h1>
	            <h3 class="advert-detail-subtitle">Ouder van Floor en Kilian</h3>
	        </div>
        </div>

        <div class="row">
	        <div class="small-12 columns advert-detail-button-container">
	        	<a class="small-7 medium-5 large-3 small-centered columns boeking-button" href="#">Opvang aanvragen</a>
	        </div>
	    </div>

	    <div class="advert-detail-description-calendar-container" data-equalizer="description-calendar" data-equalize-on="large">
	    	<div class="mobile-container">
			    <div class="small-12 large-6 columns description-container" data-equalizer-watch="description-calendar">
			    	<h2>Over deze advertentie</h2>
			    	<hr class="blue-horizontal-line"></hr>
			    	<p class="advert-detail-description"><?php echo $advert_information["advert_description"]; ?></p>

					<div class="hide-for-small show-for-large description-details">
						<div class="description-item">
							<ul>
								<li>
					    			<label data-icon="e">Basisschool <?php echo $advert_information["advert_school"]; ?></label>
				    			</li>

								<li>
					    			<label data-icon="o">Plaats voor <?php echo $advert_information["advert_spots"]; ?> kinderen</label>
				    			</li>
							</ul>
						</div>
						
						<div class="vertical-line"></div>
						
						<div class="description-item">
							<ul>
								<li>
				    				<label data-icon="m">Tussen 5 - <?php echo $advert_information["advert_price"]; ?> credits per kind</label>
				    			</li>

								<li>
				    				<label data-icon="k">Verplaatsing met <?php echo $advert_information["advert_transport"]; ?></label>
				    			</li>
							</ul>
						</div>
					</div>

					<div class="show-for-small hide-for-large description-details-mobile">
						<ul>
							<li>
				    			<label data-icon="e">Basisschool <?php echo $advert_information["advert_school"]; ?></label>
			    			</li>

							<li>
				    			<label data-icon="o">Plaats voor <?php echo $advert_information["advert_spots"]; ?> kinderen</label>
			    			</li>
			    			<li>
			    				<label data-icon="m">Tussen 5 - <?php echo $advert_information["advert_price"]; ?> credits per kind</label>
			    			</li>

							<li>
			    				<label data-icon="k">Verplaatsing met <?php echo $advert_information["advert_transport"]; ?></label>
			    			</li>
						</ul>
					</div>
				</div>

			    <div class="large-6 columns datepicker-small" data-equalizer-watch="description-calendar">
			    	<h2 class="mrgtop">Beschikbaarheid</h2>
			    	<hr class="blue-horizontal-line"></hr>

					<div class="availability-calendar"></div>
			    </div>
		    </div>
		</div>

		<div class="advert-detail-contact-map-container" data-equalizer="contact-map" data-equalize-on="large">
			<div class="mobile-container">
				<div class="small-12 large-3 columns" data-equalizer-watch="contact-map">
			    	<h2>Contact informatie</h2>
			    	<hr class="blue-horizontal-line"></hr>

					<div class="hide-for-small show-for-large advert-detail-contact-container">
				    	<span class="contact-item-icon" data-icon="x"></span>
				    	<p><?php echo $advert_information["user_email"]; ?></p>

				    	<span class="contact-item-icon" data-icon="z"></span>
				    	<p><?php echo $advert_information["user_mobile_number"]; ?></p>

				    	<span class="contact-item-icon" data-icon="q"></span>
				    	<p><?php echo $advert_information["user_home_number"]; ?></p>

				    	<span class="contact-item-icon double-line-height" data-icon="v"></span>
				    	<p><?php echo $advert_information["user_adress"]."</br>".$advert_information["user_city"]; ?></p>
			    	</div>

			    	<div class="show-for-small hide-for-large advert-detail-contact-container-mobile">
				    	<ul>
							<li>
								<label for="opvang-thuisomgeving" data-icon="x"><?php echo $advert_information["user_email"]; ?></label>
							</li>

							<li>
								<label for="ophalen-schoolpoort" data-icon="z"><?php echo $advert_information["user_mobile_number"]; ?></label>
							</li>
							<li>
								<label for="vervoer-thuis" data-icon="q"><?php echo $advert_information["user_home_number"]; ?></label>
							</li>

							<li>
								<label for="vervoer-activiteiten" data-icon="v"><?php echo $advert_information["user_adress"] . ", " . $advert_information["user_city"]; ?></label>
							</li>
						</ul>
					</div>
				</div>

				<div class="large-9 columns" data-equalizer-watch="contact-map">
					<iframe frameborder="0" style="border:0" src="<?php echo "https://www.google.com/maps/embed/v1/place?key=AIzaSyCK4od9WLji1WkDzFFyLls-226CbhN8Jl4&q=".$advert_full_adress."";?>" allowfullscreen>
					</iframe>	
				</div>
			</div>
		</div>
		
		<div class="advert-detail-services-container">
			<div class="mobile-container">
				<div class="small-12 columns">
					<h2>Aangeboden diensten</h2>
					<hr class="blue-horizontal-line"></hr>

					<div class="show-for-large services-container">
						<div class="service">
							<ul>
								<li>
									<?php
										if (in_array("opvang-thuisomgeving", $servicesArray)) {
										   	echo '<label for="opvang-thuisomgeving" data-icon="m">Opvang in een thuisomgeving</label>';
										} else {
										    echo '<label class="not-selected" for="opvang-thuisomgeving" data-icon="m">Opvang in een thuisomgeving</label>';
										}
									?>
								</li>

								<li>
									<?php
										if (in_array("ophalen-schoolpoort", $servicesArray)) {
										   	echo '<label for="ophalen-schoolpoort" data-icon="m">Ophalen aan de schoolpoort</label>';
										} else {
										    echo '<label class="not-selected" for="ophalen-schoolpoort" data-icon="m">Ophalen aan de schoolpoort</label>';
										}
									?>
								</li>
							</ul>
						</div>

						<div class="vertical-line"></div>

						<div class="service">
							<ul>
								<li>
									<?php
										if (in_array("vervoer-thuis", $servicesArray)) {
										    echo '<label for="vervoer-thuis" data-icon="m">Vervoer naar thuis na opvang</label>';
										} else {
										    echo '<label class="not-selected" for="vervoer-thuis" data-icon="m">Vervoer naar thuis na opvang</label>';
										}
									?>
								</li>

								<li>
									<?php
										if (in_array("vervoer-naschoolse-activiteiten", $servicesArray)) {
										   	echo '<label for="vervoer-activiteiten" data-icon="m">Vervoer naschoolse activiteiten</label>';
										} else {
										    echo '<label class="not-selected" for="vervoer-activiteiten" data-icon="m">Vervoer naschoolse activiteiten</label>';
										}
									?>
								</li>
							</ul>
						</div>

						<div class="vertical-line"></div>

						<div class="service">
							<ul>
								<li>
									<?php
										if (in_array("voorzien-maaltijd", $servicesArray)) {
										    echo '<label for="voorzien-maaltijd" data-icon="m">Voorzien van een maaltijd</label>';
										} else {
										    echo '<label class="not-selected" for="voorzien-maaltijd" data-icon="m">Voorzien van een maaltijd</label>';
										}
									?>
								</li>

								<li>
									<?php
										if (in_array("hulp-huiswerktaken", $servicesArray)) {
										    echo '<label for="hulp-huiswerk" data-icon="m">Hulp bij huiswerktaken</label>';
										} else {
										    echo '<label class="not-selected" for="hulp-huiswerk" data-icon="m">Hulp bij huiswerktaken</label>';
										}
									?>
								</li>
							</ul>
						</div>
					</div>

					<div class="show-for-small hide-for-large services-container-mobile">
						<ul class="services-mobile-list">
							<li>
								<?php
									if (in_array("opvang-thuisomgeving", $servicesArray)) {
									   	echo '<label for="opvang-thuisomgeving" data-icon="m">Opvang in een thuisomgeving</label>';

									} else {
									    echo '<label class="not-selected" for="opvang-thuisomgeving" data-icon="m">Opvang in een thuisomgeving</label>';
									}
								?>
							</li>

							<li>
								<?php
									if (in_array("ophalen-schoolpoort", $servicesArray)) {
									   	echo '<label for="ophalen-schoolpoort" data-icon="m">Ophalen aan de schoolpoort</label>';
									} else {
									    echo '<label class="not-selected" for="ophalen-schoolpoort" data-icon="m">Ophalen aan de schoolpoort</label>';
									}
								?>
							</li>
							<li>
								<?php
									if (in_array("vervoer-thuis", $servicesArray)) {
									    echo '<label for="vervoer-thuis" data-icon="m">Vervoer naar thuis na opvang</label>';
									} else {
									    echo '<label class="not-selected" for="vervoer-thuis" data-icon="m">Vervoer naar thuis na opvang</label>';
									}
								?>
							</li>

							<li>
								<?php
									if (in_array("vervoer-naschoolse-activiteiten", $servicesArray)) {
									   	echo '<label for="vervoer-activiteiten" data-icon="m">Vervoer naschoolse activiteiten</label>';
									} else {
									    echo '<label class="not-selected" for="vervoer-activiteiten" data-icon="m">Vervoer naschoolse activiteiten</label>';
									}
								?>
							</li>
							<li>
								<?php
									if (in_array("voorzien-maaltijd", $servicesArray)) {
									    echo '<label for="voorzien-maaltijd" data-icon="m">Voorzien van een maaltijd</label>';
									} else {
									    echo '<label class="not-selected" for="voorzien-maaltijd" data-icon="m">Voorzien van een maaltijd</label>';
									}
								?>
							</li>

							<li>
								<?php
									if (in_array("hulp-huiswerktaken", $servicesArray)) {
									    echo '<label for="hulp-huiswerk" data-icon="m">Hulp bij huiswerktaken</label>';
									} else {
									    echo '<label class="not-selected" for="hulp-huiswerk" data-icon="m">Hulp bij huiswerktaken</label>';
									}
								?>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>

		<div class="large-collapse advert-ratings-reviews-container">
		    <div class="large-12 columns">
				<div class="large-12 columns">
			    	<h2>Ratings &amp; reviews</h2>
			    	<hr class="blue-horizontal-line"></hr>
			    </div>

		    	<div id="reviews"></div>
			</div>
		</div>

		<div class="row large-collapse advert-detail-container">
	    	<div class="large-12 columns">
			    <div class="large-12 columns">
			    	<h2>Vergelijkbare advertenties</h2>
			    	<hr class="red-horizontal-line"></hr>
			    </div>
			    <?php
					$advert_results = $mysqli->prepare("SELECT advert_id, fk_user_id, advert_description, advert_price, advert_spots, advert_school, user_image_path, user_firstname, user_lastname, user_city FROM tbl_advert LEFT JOIN tbl_user ON tbl_advert.fk_user_id=tbl_user.user_id WHERE tbl_advert.advert_school = '". $advert_information['advert_school']."' LIMIT 4");
					$advert_results->execute();
					$advert_results->bind_result($advert_id, $advert_creator, $advert_description, $advert_price, $advert_spots, $advert_school, $user_profile_image, $user_first_name, $user_last_name, $user_city);

					while($advert_results->fetch()) 
					{
						$shorten = strpos($advert_description, ' ', 145);
						$final_advert_description = substr($advert_description, 0, $shorten)." ...";

						echo "
							<div class='advert-container columns end'>
							  	<a href='advert-detail.php?id=".$advert_id."' class='advert-link'>
									<div class='advert'>
						    			<div class='small-12 columns'>
							    			<div class='small-2 columns'>
							    				<img class='advert-profile-image' src='".$user_profile_image."'>
							    			</div>
							    			
							    			<div class='small-10 columns'>
								    			<ul class='advert-information-list'>
								    				<li>".$user_first_name.' '.$user_last_name."</li>
								    				<li data-icon='d'>".$user_city."</li>
								    			</ul>
							    			</div>
						    			</div>

										<p class='advert-description'>".$final_advert_description."</p>
						
						    			<div class='small-6 columns'>
							    			<div class='advert-price'>
								    			<p>".$advert_price."</p>
								    			<p>p/u</p>
							    			</div>
							    		</div>

							    		<div class='small-6 columns'>
							    			<div class='advert-spots'>
							    				<p>".$advert_spots."</p>
								    			<p>plaatsen</p>
							    			</div>
							    		</div>
				    	
							    		<p class='advert-school' data-icon='e'>Basisschool ".$advert_school."</p>
						    		</div>
						    	</a>
					    	</div>
					    ";
					}    
				?>
		    </div>
		</div>

		<?php include('../php-includes/footer.php'); ?>

		<script src="../js/minimum-viable-product.min.js"></script>
	    <script src="https://use.typekit.net/vnw3zje.js"></script>
	    <script>try{Typekit.load({ async: true });}catch(e){}</script>

	    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCK4od9WLji1WkDzFFyLls-226CbhN8Jl4&v=3"></script>

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

					$('.availability-calendar').datepicker({
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

		<script type="text/javascript">
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

				$("#reviews" ).load( "../php-assets/class.pagination-reviews.php?id="+advert_id+"");
				
				$("#reviews").on( "click", ".pagination a", function (e) {
					e.preventDefault();

					var page = $(this).attr("data-page");
					$("#reviews").load("../php-assets/class.pagination-reviews.php",{"page":page});
				});
			});
		</script>
	</body>
</html>