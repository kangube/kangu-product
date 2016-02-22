<html class="no-js" lang="nl">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Advertentie-overzicht</title>
        <link rel="stylesheet" href="../css/minimum-viable-product.min.css">
        <link href="https://file.myfontastic.com/QxAJVhmfbQ2t7NGCUAnz9P/icons.css" rel="stylesheet">
    </head>
		<body>
			<a href="advert.php"><button>Back to all adverts</button></a>
			<?php
			    
			    $con=mysqli_connect("localhost","root","root","kangu-product");
				if (mysqli_connect_errno()) {
					echo "Failed to connect to MySQL: " . mysqli_connect_error();
				}
				mysqli_select_db($con,"test");

				if(!empty($_GET))
				{

				    $location = $_GET['location'];
				    $price = $_GET['price']; 
				    $children = $_GET['children'];
				     
				    $min_length = 1;
				     
				    if(strlen($location) >= $min_length) {
				         
				        $location = htmlspecialchars($location); 
				        $price = htmlspecialchars($price); 
				         
				        $location = mysqli_real_escape_string($con, $location);
				         
				        $raw_results = mysqli_query($con, "SELECT tbl_advert.advert_id, tbl_advert.advert_name, tbl_advert.advert_price, tbl_user.user_address, tbl_advert.advert_info, tbl_user.user_numberkids FROM tbl_advert
				            LEFT JOIN tbl_user ON tbl_advert.advert_id=tbl_user.user_id WHERE (`user_address` LIKE '%".$location."%') OR( (`advert_price` LIKE '%".$price."%') OR (`user_numberkids` LIKE '%".$children."%'))") or die(mysql_error());
				         
				        if(mysqli_num_rows($raw_results) > 0) {
				            while($results = mysqli_fetch_array($raw_results)) {
				            	$pos = strpos($results['advert_info'], ' ', 125);
								$advert_description = substr($results['advert_info'], 0, $pos);

					            echo "<div class='advert-container end'>
			    					  	<a href='advertdetail.php?id=".$results['advert_id']."' class='advert-link'>
			    							<div class='advert'>
								    			<div class='small-12 columns'>
									    			<div class='small-2 columns'>
									    				<img class='advert-profile-image' src='../assets/advert-overview/user-profile-image.png'>
									    			</div>
									    			
									    			<div class='small-10 columns'>
										    			<ul class='advert-information-list'>
										    				<li>Maya Van den Broeck</li>
										    				<li data-icon='d'>Heist-op-den-Berg</li>
										    			</ul>
									    			</div>
								    			</div>

				    							<p class='advert-description'>".$advert_description."</p>
				    			
								    			<div class='small-6 columns'>
									    			<div class='advert-price'>
										    			<p>".$results['advert_price']."</p>
										    			<p>p/u</p>
									    			</div>
									    		</div>

									    		<div class='small-6 columns'>
									    			<div class='advert-spots'>
									    				<p>".$results['user_numberkids']."</p>
										    			<p>plaatsen</p>
									    			</div>
									    		</div>
						    	
									    		<p class='advert-school' data-icon='e'>Basisschool Heilig-hartcollege</p>
								    		</div>
								    	</a>
							    	</div>";
				            }
				        }
				        else {
				            echo "No results";
				        }
				         
				    }
				    else { 
				    	echo "Je hebt niet alle velden correct ingevuld";
				    }
				} ?>
		</body>
</html>