<?php

	require_once("../php-assets/class.session.php");
	require_once("../php-assets/class.user.php");
	include_once("../php-assets/class.advert.php");
	$auth_user = new USER();
	
	
	$user_id = $_SESSION['user_session'];
	
	$stmt = $auth_user->runQuery("SELECT * FROM tbl_user WHERE user_id=:user_id");
	$stmt->execute(array(":user_id"=>$user_id));
	
	$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
	
	$servername = "localhost";
	$username = "root";
	$password = "root";
	$dbname = "kangu-product";

	$conn = mysqli_connect($servername, $username, $password, $dbname);
	if (!$conn) {
	    die("Connection failed: " . mysqli_connect_error());
	}

	if(isset($_POST['SubmitButton']))
	{ 
		if(isset($_POST['descending']) && $_POST['descending'] == 'checked') 
		{
	    	echo "Allebei aangevinkt";
	    	$sql = "SELECT advert_id, advert_name FROM tbl_advert DESC";
			$result = mysqli_query($conn, $sql);

		    while($row = mysqli_fetch_assoc($result)) 
		    {
		        echo "id: " . $row["advert_id"]. " - Name: " . $row["advert_name"]. "<br>";
		    }
		}	
	}

	mysqli_close($conn);
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

        	<form method="post" class="advert-search-form">
    			<input class="search-region" type="text" placeholder="Binnen welke school zoekt u een opvangbiedende ouder?">
    			<input class="search-price" type="text" placeholder="Prijs (max.)">	
    			<select class="search-spots" name="number-children">
					<option value="1" selected>1 kind</option> 
					<option value="2">2 kinderen</option>
					<option value="3">3 kinderen</option>
					<option value="3">4 kinderen</option>
				</select>
    			<input class="search-submit" type="submit" value="Zoeken">
        	</form>

        	<button id="mobile-search-form-button" data-icon="h">Zoek opvang</button>
	    </div>

	    <div class="mobile-search-form-container">
		    <div class="row">
		    	<button id="search-form-close-button" class="close-button" type="button">
					<span aria-hidden="true">&times;</span>
				</button>

			    <div class="small-12 small-centered text-center columns">
			    	<h2>Opvang zoeken</h2>
			    	<hr class="blue-horizontal-line"></hr>
			    </div>

			    <div class="small-12 small-centered columns">
			    	<form action="search.php" method="GET" name="search" class="advert-search-form-mobile">
			    		<input type="text" name="location" placeholder="Binnen welke school zoekt u een opvangouder?" required>
			    		<select class="search-spots" name="children" required>
							<option value="1" selected>1 kind</option> 
							<option value="2">2 kinderen</option>
							<option value="3">3 kinderen</option>
							<option value="3">4 kinderen</option>
						</select>
						<input class="search-price" type="text" name="price" placeholder="Prijs (max.)" required>	
						<input class="search-submit" type="submit" value="Zoeken">
			    	</form>
			    </div>
			</div>
	    </div>

	    <div class="row large-collapse advert-overview-row">
	    	<div class="large-12 small-centered columns">
			    <div class="large-12 columns">
			    	<h2>Advertenties</h2>
			    	<hr class="blue-horizontal-line"></hr>
			    </div>

		    	<div class="loading-div"><img src="../assets/ajax-loader.gif" ></div>
				<div id="results"></div>
		    </div>
		</div>

		<div class="row">
			<div class="large-12 columns text-center">
				<p class="show-for-large-only" style="background-color: blue; color: white;">large</p>
				<p class="show-for-medium-only" style="background-color: blue; color: white;">medium</p>
				<p class="show-for-small-only" style="background-color: blue; color: white;">small</p>
			</div>
		</div>

		<script src="../js/minimum-viable-product.min.js"></script>
	    <script src="https://use.typekit.net/vnw3zje.js"></script>
	    <script>try{Typekit.load({ async: true });}catch(e){}</script>
    </body>
</html>