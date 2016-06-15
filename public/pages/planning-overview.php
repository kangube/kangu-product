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
        <style>
        .hidden {
        	display: none;
        }
        .visible {
        	display: block;
        }
        .to-boeked, .to-boeken {
        	list-style: none;
        }
        .active-button, .none-active-button{
        	text-decoration: none;
        }
        .active-button {
        	color: red !important;
        	font-weight: bold;
        	cursor: pointer;
        }
        .none-active-button {
        	color: black !important;
        	font-weight: normal;
        	cursor: default;
        }
        </style>
    </head>

	<body>	
		<?php include('../php-includes/navigation.php'); ?>
		<ul class="toggle">
			<li class="to-boeked"><a class="active-button" href="#">ik ben geboekt</a></li>
    		<li class="to-boeken"><a class="none-active-button" href="#">ik heb geboekt</a></li>
    	</ul>
		<div class="boeken visible">
			<div class="large-12 columns">
			    	<h3>Datums waarop ik anderen geboekt heb</h3>
					<?php
						//Datums tonen waarop ik anderen geboekt heb
						$booking_results = $mysqli->prepare("SELECT fk_booking_id, booking_date_format, tbl_user.user_firstname, tbl_user.user_lastname, tbl_user.user_email, tbl_user.user_mobile_number  FROM tbl_booking_dates 
							LEFT JOIN tbl_booking ON tbl_booking_dates.fk_booking_id=tbl_booking.booking_id 
							LEFT JOIN tbl_user ON tbl_booking.fk_booker_user_id=tbl_user.user_id
							WHERE tbl_booking.fk_renter_user_id = ".$userRow['user_id']."");
						$booking_results->execute();
						$booking_results->bind_result($fk_booking_id, $booking_date_format, $user_firstname, $user_lastname, $user_email, $user_mobile_number);

						while($booking_results->fetch()) 
						{
							echo "Datum: ".$booking_date_format."<br/>";
							echo "Voornaam: ".$user_firstname."<br/>";
							echo "Achternaam: ".$user_lastname."<br/>";
							echo "Email: ".$user_email."<br/>";
							echo "GSM: ".$user_mobile_number."<br/>";
						}
					?>
			</div>
			<div class="large-6 columns end">
				<div class="renter-events"></div>
			</div>
		</div>
		<div class="boeked hidden">
			<div class="large-12 columns">
		    	<h3>Datums waarop ik geboekt ben</h3>
				<?php
					//Datums tonen waarop ik anderen geboekt heb
					$booking_results = $mysqli->prepare("SELECT fk_booking_id, booking_date_format, tbl_user.user_firstname, tbl_user.user_lastname, tbl_user.user_email, tbl_user.user_mobile_number  FROM tbl_booking_dates 
						LEFT JOIN tbl_booking ON tbl_booking_dates.fk_booking_id=tbl_booking.booking_id 
						LEFT JOIN tbl_user ON tbl_booking.fk_renter_user_id=tbl_user.user_id
						WHERE tbl_booking.fk_booker_user_id = ".$userRow['user_id']."");
					$booking_results->execute();
					$booking_results->bind_result($fk_booking_id, $booking_date_format, $user_firstname, $user_lastname, $user_email, $user_mobile_number);

					while($booking_results->fetch()) 
						{
							echo "Datum: ".$booking_date_format."<br/>";
							echo "Voornaam: ".$user_firstname."<br/>";
							echo "Achternaam: ".$user_lastname."<br/>";
							echo "Email: ".$user_email."<br/>";
							echo "GSM: ".$user_mobile_number."<br/><br/>";
						}
					?>
		</div>
		<div class="large-6 columns end">
			<div id="booker-events"></div>
	</div>

</body>
</html>

<script src="../js/minimum-viable-product.min.js"></script>
<script src="http://multidatespickr.sourceforge.net/jquery-ui.multidatespicker.js"></script>
<script>
	$(document).ready(function () {
	    $('.to-boeked').on('click', function () {
	    	//Verander to-boeked naar none-active
	    	$('.to-boeked a').removeClass('active-button');
	        $('.to-boeked a').addClass('none-active-button');
	        //Verander to-boeken naar active
	        $('.to-boeken a').removeClass('none-active-button');
	        $('.to-boeken a').addClass('active-button');
	    	//Maak boeked visible
	    	$('.boeked').removeClass('hidden');
	        $('.boeked').addClass('visible');
	        //Maak boeken invisible
	        $('.boeken').removeClass('visible');
	        $('.boeken').addClass('hidden');
	    });
	    $('.to-boeken').on('click', function () {
	    	//Verander to-boeken naar none-active
	    	$('.to-boeken a').removeClass('active-button');
	        $('.to-boeken a').addClass('none-active-button');
	        //Verander to-boeked naar active
	        $('.to-boeked a').removeClass('none-active-button');
	        $('.to-boeked a').addClass('active-button');
	        //Verander to-boeken naar active
	        $('.to-boeked').removeClass('none-active-button');
	        $('.to-boeked').addClass('active-button');
	    	//Maak boeken visible
	    	$('.boeken').removeClass('hidden');
	        $('.boeken').addClass('visible');
	        //Maak boeked invisible
	        $('.boeked').removeClass('visible');
	        $('.boeked').addClass('hidden');
	    });
	});
</script>