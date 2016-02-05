<?php
	
	require_once("../php-assets/class.advert.php");


	$a1 = new Advert();
	$allAdverts = $a1->getAll();

?>
<html lang="en">
<head>
	<title>Advertentie</title>
</head>
<body>
<div class="container">
	
	<form action="search.php" method="GET">
    	<input type="text" name="query" />
    	<input type="submit" value="Search" />
	</form>

	<?php
		while($advert = $allAdverts->fetch(PDO::FETCH_ASSOC))
		{
			echo "Name: " . $advert["advert_name"] . "<br />";
			echo "Info: " . $advert["advert_info"] . "<br />";
			echo "Rating: " . $advert["advert_rating"] . "<br />";
			echo "Price: " . $advert["advert_price"] . "<br />";
			echo "Spots left: " . $advert["advert_spots"] . "<br />";
			echo "<a href='advertdetail.php?id=".$advert["advert_id"]."'><button>Show details</button></a>";
			echo "<hr>";
		}
	?>
	
</div>
</body>
</html>