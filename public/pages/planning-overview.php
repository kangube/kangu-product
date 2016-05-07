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
        </style>
    </head>

	<body>	
		<?php include('../php-includes/navigation.php'); ?>
		<ul id="toggle">
			<li class="to-boeked"><a href="#">boeken</a></li>
    		<li class="to-boeken"><a href="#">boeked</a></li>
    	</ul>
    	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
    	<script>
	    	$(document).ready(function () {
			    $('.to-boeked').on('click', function () {
			    	//Maak boeked visible
			    	$('.boeked').removeClass('hidden');
			        $('.boeked').addClass('visible');
			        //Maak boeken invisible
			        $('.boeken').removeClass('visible');
			        $('.boeken').addClass('hidden');
			    });
			    $('.to-boeken').on('click', function () {
			    	//Maak boeken visible
			    	$('.boeken').removeClass('hidden');
			        $('.boeken').addClass('visible');
			        //Maak boeked invisible
			        $('.boeked').removeClass('visible');
			        $('.boeked').addClass('hidden');
			    });
			});
    	</script>
		<div class="boeken visible">
			<div class="large-12 columns datepicker-small">
			    	<h3>Datums waarop ik anderen geboekt heb</h3>
					<?php
						//Datums tonen waarop ik anderen geboekt heb
						$booking_results = $mysqli->prepare("SELECT fk_booking_id, booking_date_format, tbl_booking.fk_booker_user_id, tbl_booking.fk_renter_user_id FROM tbl_booking_dates LEFT JOIN tbl_booking ON tbl_booking_dates.fk_booking_id=tbl_booking.booking_id WHERE tbl_booking.fk_renter_user_id = ".$userRow['user_id']."");
						$booking_results->execute();
						$booking_results->bind_result($fk_booking_id, $booking_date_format, $fk_booker_user_id, $fk_renter_user_id);

						while($booking_results->fetch()) 
						{
							echo "Datum: ".$booking_date_format."<br/>";
							echo "Gehuurde: #".$fk_booker_user_id."<br/><br/>";
						}
					?>
			</div>
			<!--<div class="large-6 columns datepicker-small">
		    	<h2 class="mrgtop">Dagen waarop ik geboekt ben</h2>
		    	<hr class="blue-horizontal-line"></hr>

				<div id="planning-events"></div>
			</div>-->
		</div>
		<div class="boeked hidden">
			<div class="large-12 columns datepicker-small">
		    	<h3>Datums waarop ik geboekt ben</h3>
				<?php
					//Datums tonen waarop ik geboekt ben
					$booking_results = $mysqli->prepare("SELECT fk_booking_id, booking_date_format, tbl_booking.fk_booker_user_id, tbl_booking.fk_renter_user_id FROM tbl_booking_dates LEFT JOIN tbl_booking ON tbl_booking_dates.fk_booking_id=tbl_booking.booking_id WHERE tbl_booking.fk_booker_user_id = ".$userRow['user_id']."");
					$booking_results->execute();
					$booking_results->bind_result($fk_booking_id, $booking_date_format, $fk_booker_user_id, $fk_renter_user_id);

					while($booking_results->fetch()) 
					{
						echo "Datum: ".$booking_date_format."<br/>";
						echo "Huurder: #".$fk_renter_user_id."<br/><br/>";
					}
				?>
		</div>
		<!--<div class="large-6 columns datepicker-small">
	    	<h2 class="mrgtop">Dagen waarop ik geboekt ben</h2>
	    	<hr class="blue-horizontal-line"></hr>

			<div id="planning-events2"></div>
		</div>-->
	</div>

</body>
</html>

<script src="http://multidatespickr.sourceforge.net/jquery-ui.multidatespicker.js"></script>
<script src="../js/minimum-viable-product.min.js"></script>