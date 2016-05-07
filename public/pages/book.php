<?php 
	
	include_once("../php-assets/class.booking.php");
	require_once("../php-assets/class.session.php");
	require_once("../php-assets/class.user.php");
	require_once("../php-assets/class.advert.php");

	$auth_user = new USER();
	$user_id = $_SESSION['user_session'];
	$stmt = $auth_user->runQuery("SELECT * FROM tbl_user WHERE user_id=:user_id");
	$stmt->execute(array(":user_id"=>$user_id));
	$userRow=$stmt->fetch(PDO::FETCH_ASSOC);

	$a1 = new Advert();
	$oneAdvert = $a1->getOne();
	$oneDate = $a1->getOneDate();
	$oneService = $a1->getOneService();

	$b1 = new Booking();

	//krijg advertentie ID nummer voor gebruik in de booking
	$advertNumber = $_GET['id'];

	if(!empty($_POST))
	{
		try 
		{	
			$b1->Advert_ID = $_POST['Advert_ID'];
			$b1->Booker_user_ID = $_POST['Booker_user_ID'];
			$b1->Renter_user_ID = $_POST['Renter_user_ID'];
			$b1->Booking_Number_Spots = $_POST['Booking_Number_Spots'];
			$b1->Booking_Price = $_POST['Booking_Price'];
			$b1->Booking_Extra_Information = $_POST['Booking_Extra_Information'];
			
			$b1->Save();

			/*-------------*/

			$originalDate = mysql_real_escape_string($_POST['Booking_Date']);
			$newDate = date("Y-m-d", strtotime($originalDate));
			//echo $newDate;
			$b1->Booking_Date = $newDate;
			
			$b1->SaveDate();
			$b1->updateAdvertNumberBookings();
			$b1->updateAvailabilitySpots();
			
			/*-------------*/

			$succes = "Thank you for booking!";
		}
		catch(Exception $e)
		{
			$error = $e->getMessage();
		}
	}

	if(!empty($_POST))
	{
		/*$post_results = $mysqli->prepare("SELECT booking_id FROM tbl_booking WHERE 
			fk_advert_id = ".$_POST['Advert_ID']." 
			AND fk_booker_user_id = ".$_POST['Booker_user_ID']." 
			AND fk_renter_user_id = ".$_POST['Renter_user_ID']."
			AND booking_number_spots = ".$_POST['Booking_Number_Spots']."
			AND booking_price = ".$_POST['Booking_Price']."
			AND booking_extra_information = ".$_POST['Booking_Extra_Information']."
			");*/
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
			//echo "$booking_id";
			$originalDate = mysql_real_escape_string($_POST['Booking_Date']);
			$newDate = date("Y-m-d", strtotime($originalDate));
			//echo $newDate;
			$b1->Booking_Date = $newDate;
			$b1->Fk_Booking_ID = $booking_id;
			
			$b1->SaveDate();
		}
	}

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Booking van Advertentie</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {		
	$(".my-activity").click(function(event) {
		//startbedrag is hieronder, standaard 0 
		var total = 5;
		$(".my-activity:checked").each(function() {
			total += parseInt($(this).val());
		});
		
		if (total == 0) {
			$('#amount').val('');
		} else {				
			$('#amount').val(total);
		}
	});
});	
</script>
</head>
<body onload="">
<div>
	<h5>welcome : <?php echo $userRow['user_email']; ?></h5>
  	<a href='logout.php'>Log out</a>
  	<br/>
  	<form method="post" action="">
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
					
					//!!!hidden value dat Advert_ID meegeeft!!!
					echo '<input type="text" id="ID" name="Advert_ID" hidden value="'.$advert["advert_id"].'"/>';
					//!!!hidden value dat Booker_user_ID meegeeft!!!
					echo '<input type="text" id="ID" name="Booker_user_ID" hidden value="'.$advert["user_id"].'"/>';
					
				}
		?>

  	</p>
		<fieldset>
		<legend>Boek mij</legend>
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
			
			<?php //hidden value dat Renter_user_ID meegeeft ?>
			<input type="text" id="ID" name="Renter_user_ID" hidden value="<?php echo $userRow['user_id']; ?>"/>

			<br/>
			
			<label for="children">Aantal kinderen dat je wilt boeken(max aantal kinderen op basis van aantal plaatsen vrij)</label><br/>
			
			<select name="Booking_Number_Spots">
			<?php
				$advertNumber = $_GET['id'];
				echo $advertNumber;

				$advertspots_results = $mysqli->prepare("SELECT availability_spots FROM tbl_availability LEFT JOIN tbl_advert ON tbl_advert.advert_id=tbl_availability.fk_advert_id WHERE tbl_advert.advert_id = ".$advertNumber."");
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
			<?php
				while($service = $oneService->fetch(PDO::FETCH_ASSOC))
				{
					if ($service["service_name"] == 'vervoer-thuis')
					{
						$value = '2';
					}
					elseif ($service["service_name"] == 'vervoer-naschoolse-activiteiten')
					{
						$value = '2';
					}
					elseif ($service["service_name"] == 'voorzien-maaltijd')
					{
						$value = '1';
					}
					elseif ($service["service_name"] == 'hulp-huiswerktaken')
					{
						$value = '2';
					}
					/*--------------*/
					if (($service["service_name"] == 'opvang-thuisomgeving')OR($service["service_name"] == 'ophalen-schoolpoort'))
					{
						echo '<input class="my-activity" type="checkbox" name="activity" value="0" disabled checked>'.$service["service_name"].'<br/>';
					}
					else 
					{
						echo '<input class="my-activity" type="checkbox" name="activity" value='.$value.'>'.$service["service_name"].'<br/>';
					}
				}
			?>
			<label for="services">Totale prijs van services</label><br/>
			<input type="text" name="Booking_Price" id="amount" />

			<br/>
			<br/>

			<div class="hide-for-small show-for-large small-12 large-6 columns datepicker-small">
		    	<label for="info">Selecteer een dag om te boeken</label><br/>

				<div id="availability-datepicker"></div>

				<input type="text" name="Booking_Date" id="altField"></input>
			</div>
			<?php
				while($date = $oneDate->fetch(PDO::FETCH_ASSOC))
				{
					echo "Datums die bij advertentie horen: ".$date["availability_date"];
					$originalDate = $date["availability_date"];
					$newDate = date("m/d/Y", strtotime($originalDate));	
					echo "<br/>Geformatteerde datum: ".$newDate;
				}
			?>
			
			<br/>
			<br/>

			<label for="info">Extra informatie</label><br/>
			<input type="text" id="info" name="Booking_Extra_Information"/>
	
			<br />
			<br />
		
			<input class="submit" type="submit" id="btnSubmit" value="Book" />
		</fieldset>
	</form>

</div>
</body>
</html>
<script src="../js/minimum-viable-product.min.js"></script>
<script src="http://multidatespickr.sourceforge.net/jquery-ui.multidatespicker.js"></script>
<script>
	var date = new Date();
	var today = new Date();
	var y = today.getFullYear();

	$('#availability-datepicker').multiDatesPicker({
		inline: true,
		//dateFormat: 'yy-mm-dd',
		firstDay: 0,
		showOtherMonths: true,
		monthNames: ['Januari', 'Februari', 'Maart', 'April', 'Mei', 'Juni', 'Juli', 'Augustus', 'September', 'Oktober', 'November', 'December'],
		dayNames: ['Zondag', 'Maandag', 'Dinsdag', 'Woensdag', 'Donderdag', 'Vrijdag', 'Zaterdag'],
		dayNamesMin: ['Zo', 'Ma', 'Di', 'Wo', 'Do', 'Vr', 'Za'],
		beforeShowDay: function (date) {
			var td = date.getDay();
			var ret = [(date.getDay() != 0 && date.getDay() != 6),'',(td != 'Za' && td != 'Zo')?'':'only on workday'];
			return ret;
		},
		altField: '#altField',
		addDates: ['<?php echo $newDate;?>'],
		maxPicks: 1
	}); 
</script>