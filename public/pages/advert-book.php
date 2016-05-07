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

	$b1 = new Booking();

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
			$succes = "Thank you for booking!";
		}
		catch(Exception $e)
		{
			$error = $e->getMessage();
		}
	}	
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Booking</title>
<link rel="stylesheet" type="text/css" media="all" href="css/reset.css" />
<link rel="stylesheet" type="text/css" media="all" href="css/screen.css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {		
	$(".my-activity").click(function(event) {
		//startbedrag is hieronder, standaard 0 
		var total = 0;
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
			
			<label for="children">Aantal kinderen</label><br/>
			<select name="Booking_Number_Spots">
			  <option value="1" selected>1 kind</option>
			  <option value="2">2 kinderen</option>
			  <option value="3">3 kinderen</option>
			  <option value="4">4 kinderen</option>
			</select>

			<br/>
			<br/>

			<label for="info">Vink de services aan die je wil gebruiken</label><br/>		
			<input class="my-activity" type="checkbox" name="activity" value="5"> Service 1 (EUR 5)<br/>
			<input class="my-activity" type="checkbox" name="activity" value="10"> Service 2 (EUR 10)<br/>
			<input class="my-activity" type="checkbox" name="activity" value="15"> Service 3 (EUR 15)<br/>		

			<label for="services">Totale prijs van services</label><br/>
			<input type="text" name="Booking_Price" id="amount" />

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