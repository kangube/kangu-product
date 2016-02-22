<?php
	
	require_once("../php-assets/class.advert.php");


	$a1 = new Advert();
	$allAdverts = $a1->getOne();

?>
<html lang="en">
<head>
	<title>Advertentie detail</title>
</head>
<body>
<div class="container">
		
	<?php
		while($advert = $allAdverts->fetch(PDO::FETCH_ASSOC))
		{
			echo "Name: " . $advert["advert_name"] . "<br />";
			echo "Info: " . $advert["advert_info"] . "<br />";
			echo "Rating: " . $advert["advert_rating"] . "<br />";
			echo "Price: " . $advert["advert_price"] . "<br />";
			echo "Spots left: " . $advert["advert_spots"] . "<br />";
			echo "<hr>";
		}
	?>

	<a href="advert.php"><button>Back to all adverts</button></a>
	
</div>
</body>
</html>