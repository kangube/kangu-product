<?php

	require_once("../php-assets/class.session.php");
	
	require_once("../php-assets/class.user.php");
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
		<div class="row">
			<div class="large-12 small-centered columns">
				<div class="title-bar" data-responsive-toggle="top-bar-menu" data-hide-for="medium">
			        <button class="menu-icon" type="button" data-toggle></button>
			        <div class="title-bar-title">kangu</div>
				</div>
		      
				<div class="top-bar" id="top-bar-menu">
					<div class="top-bar-title show-for-medium">kangu</div>

					<div class="top-bar-right">
						<ul class="vertical medium-horizontal menu">
							<li><button type="button" class="provide-services-button">Bied opvang aan</button></li>
							<li><a href="#">Advertenties</a></li>
							<li><a href="#">Schema</a></li>
							<li><a href="#">Transacties</a></li>
							<li><a href="#" class="show-for-medium" data-icon="g"></a></li>
							<li>
								<ul class="dropdown menu user-dropdown-menu" data-dropdown-menu>
									<li><img class="user-profile-image" src="../assets/advert-overview/user-profile-image.png"></li>
									<li>
										<a href="#">Jenny Doe</a>
										<ul class="vertical menu">
											<li><a href="#">Afmelden</a></li>
										</ul>
									</li>
								</ul>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>

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
    			<input class="search-region" type="text" placeholder="In welke regio zoekt u een opvangbiedende ouder?">
    			<input class="search-price" type="text" placeholder="Prijs (max.)">	
    			<select class="search-spots" name="number-children">
					<option value="1" selected>1 kind</option> 
					<option value="2">2 kinderen</option>
					<option value="3">3 kinderen</option>
				</select>	
    			<input class="search-submit" type="submit" value="Zoeken">
        	</form>
	    </div>

	    <div class="row large-collapse advert-overview-row">
	    	<div class="large-12 small-centered columns">
			    <div class="large-12 columns">
			    	<h2>Advertenties</h2>
			    	<hr class="blue-horizontal-line"></hr>
			    </div>
			    
	    		<div class="small-6 medium-4 large-3 columns end">
		    		<a href="#" class="advert-link">
		    			<div class="advert">
			    			<div class="small-12 columns">
				    			<div class="small-2 columns">
				    				<img class="advert-profile-image" src="../assets/advert-overview/user-profile-image.png">
				    			</div>
				    			
				    			<div class="small-10 columns">
					    			<ul class="advert-information-list">
					    				<li>Maya Van den Broeck</li>
					    				<li data-icon="d">Heist-op-den-Berg</li>
					    			</ul>
				    			</div>
			    			</div>

			    			<p class="advert-description">Ik ben Maya, 23 jaar woonachtig te zwevegem. Hoofdleiding in een Chiro en op zoek naar een nieuwe vaste job. Met kinderen ...</p>
			    			
			    			<div class="small-6 columns">
				    			<div class="advert-price">
					    			<p>5</p>
					    			<p>p/u</p>
				    			</div>
				    		</div>

				    		<div class="small-6 columns">
				    			<div class="advert-spots">
				    				<p>2</p>
					    			<p>plaatsen</p>
				    			</div>
				    		</div>
					    	
				    		<p class="advert-school" data-icon="e">Basisschool Heilig-hartcollege</p>
			    		</div>
			    	</a>
		    	</div>

		    	<div class="small-6 medium-4 large-3 columns end">
		    		<a href="#" class="advert-link">
		    			<div class="advert">
			    			<div class="small-12 columns">
				    			<div class="small-2 columns">
				    				<img class="advert-profile-image" src="../assets/advert-overview/user-profile-image.png">
				    			</div>
				    			
				    			<div class="small-10 columns">
					    			<ul class="advert-information-list">
					    				<li>Maya Van den Broeck</li>
					    				<li data-icon="d">Heist-op-den-Berg</li>
					    			</ul>
				    			</div>
			    			</div>

			    			<p class="advert-description">Ik ben Maya, 23 jaar woonachtig te zwevegem. Hoofdleiding in een Chiro en op zoek naar een nieuwe vaste job. Met kinderen ...</p>
			    			
			    			<div class="small-6 columns">
				    			<div class="advert-price">
					    			<p>5</p>
					    			<p>p/u</p>
				    			</div>
				    		</div>

				    		<div class="small-6 columns">
				    			<div class="advert-spots">
				    				<p>2</p>
					    			<p>plaatsen</p>
				    			</div>
				    		</div>
					    	
				    		<p class="advert-school" data-icon="e">Basisschool Heilig-hartcollege</p>
			    		</div>
			    	</a>
		    	</div>

		    	<div class="small-12 medium-4 large-3 columns end">
		    		<a href="#" class="advert-link">
		    			<div class="advert">
			    			<div class="small-12 columns">
				    			<div class="small-2 columns">
				    				<img class="advert-profile-image" src="../assets/advert-overview/user-profile-image.png">
				    			</div>
				    			
				    			<div class="small-10 columns">
					    			<ul class="advert-information-list">
					    				<li>Maya Van den Broeck</li>
					    				<li data-icon="d">Heist-op-den-Berg</li>
					    			</ul>
				    			</div>
			    			</div>

			    			<p class="advert-description">Ik ben Maya, 23 jaar woonachtig te zwevegem. Hoofdleiding in een Chiro en op zoek naar een nieuwe vaste job. Met kinderen ...</p>
			    			
			    			<div class="small-6 columns">
				    			<div class="advert-price">
					    			<p>5</p>
					    			<p>p/u</p>
				    			</div>
				    		</div>

				    		<div class="small-6 columns">
				    			<div class="advert-spots">
				    				<p>2</p>
					    			<p>plaatsen</p>
				    			</div>
				    		</div>
					    	
				    		<p class="advert-school" data-icon="e">Basisschool Heilig-hartcollege</p>
			    		</div>
			    	</a>
		    	</div>

		    	<div class="small-12 medium-4 large-3 columns end">
		    		<a href="#" class="advert-link">
		    			<div class="advert">
			    			<div class="small-12 columns">
				    			<div class="small-2 columns">
				    				<img class="advert-profile-image" src="../assets/advert-overview/user-profile-image.png">
				    			</div>
				    			
				    			<div class="small-10 columns">
					    			<ul class="advert-information-list">
					    				<li>Maya Van den Broeck</li>
					    				<li data-icon="d">Heist-op-den-Berg</li>
					    			</ul>
				    			</div>
			    			</div>

			    			<p class="advert-description">Ik ben Maya, 23 jaar woonachtig te zwevegem. Hoofdleiding in een Chiro en op zoek naar een nieuwe vaste job. Met kinderen ...</p>
			    			
			    			<div class="small-6 columns">
				    			<div class="advert-price">
					    			<p>5</p>
					    			<p>p/u</p>
				    			</div>
				    		</div>

				    		<div class="small-6 columns">
				    			<div class="advert-spots">
				    				<p>2</p>
					    			<p>plaatsen</p>
				    			</div>
				    		</div>
					    	
				    		<p class="advert-school" data-icon="e">Basisschool Heilig-hartcollege</p>
			    		</div>
			    	</a>
		    	</div>
		    </div>
		</div>

		<div class="row">
			<div class="large-12 columns text-center">
				<p class="show-for-large-only" style="background-color: blue; color: white;">large</p>
				<p class="show-for-medium-only" style="background-color: blue; color: white;">medium</p>
				<p class="show-for-small-only" style="background-color: blue; color: white;">small</p>
			</div>
		</div>

	    <div class="row">
		    <div class="large-12 columns">
				<ul class="pagination" role="navigation" aria-label="Pagination">
					<li class="pagination-previous"><a href="#" aria-label="Previous page">Vorige pagina</a></li>
					<li><a href="#" aria-label="Page 1">1</a></li>
					<li class="current"><a href="#" aria-label="Page 2">2</a></li>
					<li><a href="#" aria-label="Page 3">3</a></li>
					<li><a href="#" aria-label="Page 4">4</a></li>
					<li class="ellipsis"></li>
					<li><a href="#" aria-label="Page 12">12</a></li>
					<li><a href="#" aria-label="Page 13">13</a></li>
					<li class="pagination-next"><a href="#" aria-label="Next page">Volgende pagina</a></li>
				</ul>
		    </div>
	    </div>

		<script src="../js/minimum-viable-product.min.js"></script>
	    <script src="https://use.typekit.net/vnw3zje.js"></script>
	    <script>try{Typekit.load({ async: true });}catch(e){}</script>
    </body>
</html>