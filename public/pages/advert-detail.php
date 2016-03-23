<?php
	require_once("../php-assets/class.session.php");
	require_once("../php-assets/class.user.php");
	require_once("../php-assets/class.advert.php");
	require_once("../php-assets/class.pagination-reviews.php");

	$auth_user = new USER();
	$user_id = $_SESSION['user_session'];
	$stmt = $auth_user->runQuery("SELECT * FROM tbl_user WHERE user_id=:user_id");
	$stmt->execute(array(":user_id"=>$user_id));
	$userRow=$stmt->fetch(PDO::FETCH_ASSOC);

	$advert = new Advert();
	$oneAdvert = $advert->getOne();
	$advert_information = $oneAdvert->fetch(PDO::FETCH_ASSOC);

	$advert_full_adress = $advert_information['user_adress'].','.$advert_information['user_city'];
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
	        	<a class="small-7 medium-5 large-3 small-centered columns boeking-button" href="#">Boeking aanvragen</a>
	        </div>
	    </div>
	    <div class="row advert-detail-calendar">
	    	<div class="large-12 columns">
			    <div class="small-12 medium-12 large-6 columns">
			    	<h2>Over deze advertentie</h2>
			    	<hr class="blue-horizontal-line"></hr>
			    	<p><?php echo $advert_information["advert_description"]; ?></p>
					<div class="flex-container">
						<div class="flex-item">
							<ul>
								<li>
									<span data-icon="e"></span>
					    			<p>Basisschool <?php echo $advert_information["advert_school"]; ?></p>
				    			</li>
								<li>
									<span data-icon="o"></span>
					    			<p>Plaats voor <?php echo $advert_information["advert_spots"]; ?> kinderen</p>
				    			</li>
							</ul>
						</div>
						
						<div class="vertical-line"></div>
						
						<div class="flex-item">
							<ul>
								<li>
									<span data-icon="m"></span>
				    				<p>Tussen 5 - <?php echo $advert_information["advert_price"]; ?> euro per uur</p>
				    			</li>
								<li>
									<span data-icon="k"></span>
				    				<p>Verplaatsing met <?php echo $advert_information["advert_transport"]; ?></p>
				    			</li>
							</ul>
						</div>
					</div>
			    </div>

			    <!--<div class="small-12 medium-12 large-6 columns">
			    	<h2 class="mrgtop">Beschikbaarheid</h2>
			    	<hr class="blue-horizontal-line"></hr>
			    	
				</div>-->

				<div class="small-12 large-6 columns">
					<div id="availability-datepicker"></div>
				</div>
			    	
			    </div>
		  	</div>
		</div>
		<div class="row advert-detail-map">
			<div class="large-12 columns">
				<div class="small-12 medium-12 large-3 columns">
			    	<h2>Contact informatie</h2>
			    	<hr class="blue-horizontal-line"></hr>
					<div class="flleft">
				    	<span data-icon="x"></span>
				    	<p><?php echo $advert_information["user_email"]; ?></p>
				    	<span data-icon="z"></span>
				    	<p><?php echo "+32 " . $advert_information["user_mobile_number"]; ?></p>
			    	</div>
			    	<div class="flleft">
				    	<span data-icon="q"></span>
				    	<p><?php echo "+32 " . $advert_information["user_home_number"]; ?></p>
				    	<span class="double-line-height" data-icon="v"></span>
				    	<p><?php echo $advert_information["user_adress"] . "<br > " . $advert_information["user_city"]; ?></p>
			    	</div>
				</div>
				<div class="small-12 medium-12 large-9 columns">
					<iframe
					  frameborder="0" style="border:0"
					
					<?php echo "src='https://www.google.com/maps/embed/v1/place?key=AIzaSyCK4od9WLji1WkDzFFyLls-226CbhN8Jl4&q=".$advert_full_adress."'";?> allowfullscreen>
					</iframe>	
				</div>
			</div>
		</div>

		<div class="row advert-detail-services">
			<div class="large-12 columns">
			    <h2>Aangeboden diensten</h2>
			    <hr class="blue-horizontal-line"></hr>
			    <?php
					/*$advert_services = $mysqli->prepare("SELECT advert_id, advert_service, fk_advert_id, fk_service_id, service_id, service_name, service_availability 
						FROM tbl_advert_service 
						LEFT JOIN tbl_advert ON tbl_advert_service.fk_advert_id=tbl_advert.advert_id 
						LEFT JOIN tbl_advert_service ON tbl_advert_service.fk_service_id=tbl_service.service_id
						WHERE tbl_advert.advert_id = '". $advert_information['advert_id'] ."");
					$advert_services->execute();
					$advert_services->bind_result($advert_id, $advert_service, $service_id, $service_name, $service_availability);

					echo $advert_services;*/
				?>
				<div class="flex-container">
					<div class="flex-item">
						<ul>
							<li>
								<span class="extra" data-icon="m"></span>
			    				<p>Opvang in een thuisomgeving</p>
			    			</li>
							<li>
								<span class="extra" data-icon="m"></span>
			    				<p>Ophalen aan de schoolpoort</p>
			    			</li>
						</ul>
					</div>
					
					<div class="vertical-line"></div>
					
					<div class="flex-item">
						<ul>
							<li>
								<span class="extra" data-icon="m"></span>
			    				<p>Vervoer naar thuis na opvang</p>
			    			</li>
							<li>
								<span class="extra" data-icon="m"></span>
			    				<p>Ophalen aan de schoolpoort</p>
			    			</li>
						</ul>
					</div>
					
					<div class="vertical-line"></div>
					
					<div class="flex-item">
						<ul>
							<li>
								<span class="extra" data-icon="m"></span>
			    				<p>Voorzien van een maaltijd</p>
			    			</li>
							<li>
								<span class="extra" data-icon="m"></span>
			    				<p>Hulp bij huiswerk taken</p>
			    			</li>
						</ul>
					</div>
				</div>
			</div>
		</div>

		<div class="large-collapse row advert-detail-ratings">
		    <div class="large-12 columns">
				<div class="large-12 columns">
			    	<h2>Ratings &amp; reviews</h2>
			    	<hr class="blue-horizontal-line"></hr>
			    </div>

			    <div class="large-12 columns">
			    	<div id="reviews"></div>
			    </div>
			</div>
		</div>

		<div class="test">
		<div class="row large-collapse advert-detail-container">
	    	<div class="large-12 columns">
			    <div class="large-12 columns">
			    	<h2>Vergelijkbare advertenties</h2>
			    	<hr class="red-horizontal-line"></hr>
			    </div>
			    <?php
					$advert_results = $mysqli->prepare("SELECT advert_id, fk_user_id, advert_description, advert_price, advert_spots, advert_school, user_image_path, user_firstname, user_lastname, user_city FROM tbl_advert LEFT JOIN tbl_user ON tbl_advert.fk_user_id=tbl_user.user_id WHERE tbl_advert.advert_school = '". $advert_information['advert_school']."' LIMIT 3");
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
		</div>
		
		<script src="../js/minimum-viable-product.min.js"></script>
	    <script src="https://use.typekit.net/vnw3zje.js"></script>
	    <script>try{Typekit.load({ async: true });}catch(e){}</script>
	
		<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCK4od9WLji1WkDzFFyLls-226CbhN8Jl4&callback=initMap"></script>
		<script type="text/javascript">
			$(document).ready(function() 
			{

				//-----------
				$("#reviews" ).load( "../php-assets/class.pagination-reviews.php"); //load initial records

	    		$("#hide").click(function(e) {
	        		$("#reviews").hide();

	    		});
				//executes code below when user click on pagination links
				$("#reviews").on( "click", ".pagination a", function (e)
				{
					e.preventDefault();
					$(".loading-div").show(); //show loading element
					var page = $(this).attr("data-page"); //get page number from link
					$("#reviews").load("../php-assets/class.pagination-reviews.php",{"page":page}, function()
					{ //get content from PHP page
						$(".loading-div").hide(); //once done, hide loading element
					});
				});
			});
		</script>

	    <script src="http://multidatespickr.sourceforge.net/jquery-ui.multidatespicker.js"></script>
	    <script>
	    	$('#availability-datepicker').multiDatesPicker({
		        inline: true,
			    dateFormat: 'yy-mm-dd',
			    firstDay: 0,
			    showOtherMonths: true,
			    monthNames: ['Januari', 'Februari', 'Maart', 'April', 'Mei', 'Juni', 'Juli', 'Augustus', 'September', 'Oktober', 'November', 'December'],
			    dayNames: ['Zondag', 'Maandag', 'Dinsdag', 'Woensdag', 'Donderdag', 'Vrijdag', 'Zaterdag'],
			    dayNamesMin: ['Zo', 'Ma', 'Di', 'Wo', 'Do', 'Vr', 'Za'],
			    beforeShowDay: function (date) {
			        var td = date.getDay();
			        var ret = [(date.getDay() != 0 && date.getDay() != 6),'',(td != 'Za' && td != 'Zo')?'':'only on workday'];
			        return ret;
			    }
		    });
	    </script>
	</body>
</html>