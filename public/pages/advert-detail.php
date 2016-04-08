<?php

	require_once("../php-assets/class.advert.php");

	$a1 = new Advert();
	$oneAdvert = $a1->getOne();
?>

<!doctype html>
<html class="no-js" lang="nl">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Advertentie-detail</title>
        <link rel="stylesheet" href="../css/minimum-viable-product.min.css">
        <link href="https://file.myfontastic.com/QxAJVhmfbQ2t7NGCUAnz9P/icons.css" rel="stylesheet">
    </head>

	<body>
		<div class="row">	
			<?php
				while($advert = $oneAdvert->fetch(PDO::FETCH_ASSOC))
				{
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
					//Voor te boeken, unieke link per advert
					echo "<a href='book.php?id=".$advert["advert_id"]."' class='advert-link'>Boek mij</a>";
				}
			?>	
		</div>
	</body>
</html>