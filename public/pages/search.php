<html>
<head>
</head>
<body>
	<a href="advert.php"><button>Back to all adverts</button></a>
	<?php
	    
	    $con=mysqli_connect("localhost","root","root","kangu-product");
		if (mysqli_connect_errno())
			{
				echo "Failed to connect to MySQL: " . mysqli_connect_error();
			}
		mysqli_select_db($con,"test");

		if(!empty($_GET))
		{

	    $location = $_GET['location'];
	    $price = $_GET['price']; 
	    $children = $_GET['children'];  
	    // gets value sent over search form
	     
	    $min_length = 1;
	    // you can set minimum length of the query if you want
	     
	    if(strlen($location) >= $min_length){ // if query length is more or equal minimum length then
	         
	        $location = htmlspecialchars($location); 
	        $price = htmlspecialchars($price); 
	        // changes characters used in html to their equivalents, for example: < to &gt;
	         
	        $location = mysqli_real_escape_string($con, $location);
	        // makes sure nobody uses SQL injection
	         
	        $raw_results = mysqli_query($con, "SELECT tbl_advert.advert_id, tbl_advert.advert_name, tbl_advert.advert_price, tbl_user.user_address, tbl_advert.advert_info, tbl_user.user_numberkids FROM tbl_advert
	            LEFT JOIN tbl_user ON tbl_advert.advert_id=tbl_user.user_id WHERE (`user_address` LIKE '%".$location."%') OR( (`advert_price` LIKE '%".$price."%') OR (`user_numberkids` LIKE '%".$children."%'))") or die(mysql_error());
	             
	        // * means that it selects all fields, you can also write: `id`, `title`, `text`
	        // articles is the name of our table
	         
	        // '%$query%' is what we're looking for, % means anything, for example if $query is Hello
	        // it will match "hello", "Hello man", "gogohello", if you want exact match use `title`='$query'
	        // or if you want to match just full word so "gogohello" is out use '% $query %' ...OR ... '$query %' ... OR ... '% $query'
	         
	        if(mysqli_num_rows($raw_results) > 0){ // if one or more rows are returned do following
	             
	            while($results = mysqli_fetch_array($raw_results)){
	            // $results = mysql_fetch_array($raw_results) puts data from database into array, while it's valid it does the loop
	             
	            echo "<p>
	            <h2>".$results['advert_name']."</h2>"."<h3>Informatie:</h3>".$results['advert_info']."<br/>Prijs: ".$results['advert_price']."<br/>Regio: ".$results['user_address']."<br/>Plaats voor: ".$results['user_numberkids']." kinderen</p><a href='advertdetail.php?id=" . $results['advert_id'] . "'><button>Show details</button></a><hr/>";
	
	                
	            }
	             
	        }
	        else{ // if there is no matching rows do following
	            echo "No results";
	        }
	         
	    }
	    else // if query length is less than minimum
	    { 
	    	echo "Je hebt niet alle velden correct ingevuld";
	    }
		}
		?></body>
</html>