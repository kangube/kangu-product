<?php
	require_once("../php-assets/class.session.php");
	include_once("../php-assets/class.user.php");
	include_once("../php-assets/class.advert.php");

	$auth_user = new USER();
	$user_id = $_SESSION['user_session'];
	$stmt = $auth_user->runQuery("SELECT * FROM tbl_user WHERE user_id=:user_id");
	$stmt->execute(array(":user_id"=>$user_id));
	$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
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
		
		<div class="advert-overview-header" data-interchange="[../assets/advert-overview/advert-background-1366.jpg, default], 
                                   [../assets/advert-overview/advert-background-320.jpg, only screen and (min-width: 0px) and (max-width: 320px)],
                                   [../assets/advert-overview/advert-background-480.jpg, only screen and (min-width: 321px) and (max-width: 480px)], 
                                   [../assets/advert-overview/advert-background-640.jpg, only screen and (min-width: 481px) and (max-width: 640px)],
                                   [../assets/advert-overview/advert-background-720.jpg, only screen and (min-width: 641px) and (max-width: 720px)], 
                                   [../assets/advert-overview/advert-background-1024.jpg, only screen and (min-width: 721px) and (max-width: 1024px)], 
                                   [../assets/advert-overview/advert-background-1280.jpg, only screen and (min-width: 1025px) and (max-width: 1280px)], 
                                   [../assets/advert-overview/advert-background-1366.jpg, only screen and (min-width: 1281px) and (max-width: 1366px)], 
                                   [../assets/advert-overview/advert-background-1440.jpg, only screen and (min-width: 1367px) and (max-width: 1440px)], 
                                   [../assets/advert-overview/advert-background-1680.jpg, only screen and (min-width: 1441px) and (max-width: 1680px)], 
                                   [../assets/advert-overview/advert-background-1920.jpg, only screen and (min-width: 1681px) and (max-width: 1920px)],
                                   [../assets/advert-overview/advert-background-2560.jpg, only screen and (min-width: 1920px)], 
                                   [../assets/advert-overview/advert-background-1920.jpg, retina]">
	        
	        
	        <div class="advert-overview-title-container">
	            <h1 class="advert-overview-title">Vind de ideale opvang voor uw kind</h1>
	            <h3 class="advert-overview-subheader">Deze header wordt vergezeld van een subheader met bijbehorende informatie over de pagina</h3>
	        </div>

        	<form action="advert-overview.php" method="get" name="search" class="advert-search-form">
    			<input class="search-region" type="text" placeholder="Binnen welke school zoekt u een opvangbiedende ouder?" name="school" required>
    			<input class="search-price" type="text" placeholder="Prijs (max.)" name="price" required>
    			<select class="search-spots" name="number-children" required>
					<option value="1" selected>1 kind</option> 
					<option value="2">2 kinderen</option>
					<option value="3">3 kinderen</option>
					<option value="4">4 kinderen</option>
				</select>
    			<input id="search-submit-button" class="search-submit" type="submit" value="Zoeken" name="search">
        	</form>

        	<button id="mobile-search-form-button" data-icon="h">Zoek opvang</button>
	    </div>

	    <div class="mobile-search-form-container">
		    <div class="row">
		    	<button id="search-form-close-button" class="close-button" type="button">
					<span aria-hidden="true">&times;</span>
				</button>

			    <div class="mobile-search-form-header">
			    	<h2>Opvang zoeken</h2>
			    	<hr class="blue-horizontal-line"></hr>
			    </div>

			    <div class="mobile-search-form">
			    	<form action="advert-overview.php" method="get" name="search" class="advert-search-form-mobile">
			    		<input type="text" placeholder="Binnen welke school zoekt u een opvangouder?" name="school" required>
			    		<select class="search-spots" name="number-children" required>
							<option value="1" selected>1 kind</option> 
							<option value="2">2 kinderen</option>
							<option value="3">3 kinderen</option>
							<option value="3">4 kinderen</option>
						</select>
						<input class="search-price" type="text" placeholder="Prijs (max.)" name="price" required>
						<input class="search-submit" type="submit" name="search" value="Zoeken">
			    	</form>
			    </div>
			</div>
	    </div>

	    <div class="large-collapse advert-overview-container">
	    	<div class="large-12 columns">
			    <div class="large-10 columns">
			    	<h2>Advertenties</h2>
			    	<hr class="blue-horizontal-line"></hr>
			    </div>

			    <div class="large-2 columns">
			    	<form action="advert-overview.php" method="post">
						<select class="advert-overview-filter" name='advert-overview-filter' onchange="this.form.submit()">
							<option selected="selected">Filter advertenties</option>
							<option value="recent">Meest recent</option>
							<option value="popular">Meest populair</option>
							<option value="descending">Prijs hoog - laag</option>
							<option value="ascending">Prijs laag - hoog</option>
						</select>
					</form>
			    </div>
			</div>

			<div class="large-12 columns">

				<?php

				$con = mysqli_connect("localhost","root","root","kangu-product");
				if (mysqli_connect_errno())
				{
				  echo "Failed to connect to MySQL: " . mysqli_connect_error();
				}
				mysqli_select_db($con,"test");

				if(!isset($_POST['advert-overview-filter']))
				{
					//Standaard, Display all results
					echo "<div id='results'></div>";
				}
				else if (isset($_POST['advert-overview-filter'])) {
					switch($_POST['advert-overview-filter']){
						// Display the most popular adverts
						case 'popular':
							$advert_results = $mysqli->prepare("SELECT advert_id, fk_user_id, advert_description, advert_price, advert_spots, advert_school, user_image_path, user_firstname, user_lastname, user_city FROM tbl_advert LEFT JOIN tbl_user ON tbl_advert.fk_user_id=tbl_user.user_id ORDER BY advert_number_bookings DESC");
						break;

						// Display the most recently created adverts
						case 'recent':
							$advert_results = $mysqli->prepare("SELECT advert_id, fk_user_id, advert_description, advert_price, advert_spots, advert_school, user_image_path, user_firstname, user_lastname, user_city FROM tbl_advert LEFT JOIN tbl_user ON tbl_advert.fk_user_id=tbl_user.user_id ORDER BY advert_id DESC");
						break;

						// Display all adverts while ordering by an ascending price
						case 'ascending':
							$advert_results = $mysqli->prepare("SELECT advert_id, fk_user_id, advert_description, advert_price, advert_spots, advert_school, user_image_path, user_firstname, user_lastname, user_city FROM tbl_advert LEFT JOIN tbl_user ON tbl_advert.fk_user_id=tbl_user.user_id ORDER BY advert_price ASC");
						break;

						// Display all adverts while ordering by an descending price
						case 'descending':
							$advert_results = $mysqli->prepare("SELECT advert_id, fk_user_id, advert_description, advert_price, advert_spots, advert_school, user_image_path, user_firstname, user_lastname, user_city FROM tbl_advert LEFT JOIN tbl_user ON tbl_advert.fk_user_id=tbl_user.user_id ORDER BY advert_price DESC");
						break;

						// Display all adverts
						default:
						echo "<div id='results'></div>";
					}

					$advert_results->execute();
					$advert_results->bind_result($advert_id, $advert_creator, $advert_description, $advert_price, $advert_spots, $advert_school, $user_profile_image, $user_first_name, $user_last_name, $user_city);

					while($advert_results->fetch()) 
					{
						$shorten = strpos($advert_description, ' ', 145);
						$final_advert_description = substr($advert_description, 0, $shorten)." ...";

						echo "<div class='advert-container end'>
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
					    	</div>";
					}
				}
				?>
		    </div>
		</div>

		<script src="../js/minimum-viable-product.min.js"></script>
	    <script src="https://use.typekit.net/vnw3zje.js"></script>
	    <script>try{Typekit.load({ async: true });}catch(e){}</script>

	    <script>
	    	$(document).ready(function() {
				$(".advert-search-form, .advert-search-form-mobile").on("submit", function (e) {
					e.preventDefault();
					var school = $('.search-region').val();
		    		var price = $('.search-price').val();
		    		var spots = $('.search-spots').val();

					$.ajax({
						type: 'GET',
						dataType: 'html',
						url: 'search.php',
						data: {school:school, price:price, spots:spots},
						cache: false,
						success: function(response) {
							$("#results").css("display", "none");
							$(".advert-overview-container" ).html(response);
						}
					});
				});
			});
	    </script>
    </body>
</html>