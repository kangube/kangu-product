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
	        
	        
	        <div class="advert-overview-header-container">
	            <h1 class="advert-overview-header">Vind de ideale opvang voor uw kind</h1>
	            <h3 class="advert-overview-subheader">Kies tussen tal van advertenties en vind de geschikte opvangbiedende ouder om uw kinderen op te vangen</h3>
	        </div>

        	<form action="advert-overview.php" method="get" name="search" class="advert-search-form">
    			<input class="search-region" type="text" placeholder="Binnen welke school zoekt u een opvangbiedende ouder?" name="school" required>
    			<input class="search-date" type="text" placeholder="op welke datum?" name="date" required>
    			<select class="search-spots" name="number-children" required>
					<option value="1" selected>1 kind</option> 
					<option value="2">2 kinderen</option>
					<option value="3">3 kinderen</option>
					<option value="4">4 kinderen</option>
					<option value="5">5 kinderen</option>
					<option value="6">6 kinderen</option>
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
			    		<input class="search-region-mobile" type="text" placeholder="Binnen welke school zoekt u een opvangouder?" name="school" required>
			    		<div class="search-date-mobile"></div>
						<input class="search-date-mobile-alt" type="hidden">
						<select class="search-spots-mobile" name="number-children" required>
							<option value="1" selected>1 kind</option> 
							<option value="2">2 kinderen</option>
							<option value="3">3 kinderen</option>
							<option value="3">4 kinderen</option>
							<option value="5">5 kinderen</option>
							<option value="6">6 kinderen</option>
						</select>
						<input class="search-submit" type="submit" name="search" value="Zoeken">
			    	</form>
			    </div>
			</div>
	    </div>

	    <div class="large-collapse advert-overview-container"></div>
	    <div class="large-collapse search-advert-overview-container"></div>

		<?php include('../php-includes/footer.php'); ?>

		<script src="../js/minimum-viable-product.min.js"></script>
	    <script src="https://use.typekit.net/vnw3zje.js"></script>
	    <script>try{Typekit.load({ async: true });}catch(e){}</script>

	    <script src="http://multidatespickr.sourceforge.net/jquery-ui.multidatespicker.js"></script>
	    <script>
	    	$(document).ready(function() {
				// Input datepicker for large screens and up

				$(".search-date").multiDatesPicker({
					inline: false,
					dateFormat: 'yy-mm-dd',
					firstDay: 0,
				    showOtherMonths: true,
				    monthNames: ['Januari', 'Februari', 'Maart', 'April', 'Mei', 'Juni', 'Juli', 'Augustus', 'September', 'Oktober', 'November', 'December'],
				    dayNames: ['Zondag', 'Maandag', 'Dinsdag', 'Woensdag', 'Donderdag', 'Vrijdag', 'Zaterdag'],
				    dayNamesMin: ['Zo', 'Ma', 'Di', 'Wo', 'Do', 'Vr', 'Za']
				});

				// Input datepicker for medium screens and down
				
				$(".search-date-mobile").multiDatesPicker({
					inline: true,
					dateFormat: 'yy-mm-dd',
					firstDay: 0,
				    showOtherMonths: true,
				    monthNames: ['Januari', 'Februari', 'Maart', 'April', 'Mei', 'Juni', 'Juli', 'Augustus', 'September', 'Oktober', 'November', 'December'],
				    dayNames: ['Zondag', 'Maandag', 'Dinsdag', 'Woensdag', 'Donderdag', 'Vrijdag', 'Zaterdag'],
				    dayNamesMin: ['Zo', 'Ma', 'Di', 'Wo', 'Do', 'Vr', 'Za'],
				    altFormat: "yy-mm-dd",
					altField: ".search-date-mobile-alt"
				});
			});
	    </script>
    </body>
</html>