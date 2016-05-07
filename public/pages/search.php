<html class="no-js" lang="nl">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Advertentie-overzicht</title>
        <link rel="stylesheet" href="../css/minimum-viable-product.min.css">
        <link href="https://file.myfontastic.com/QxAJVhmfbQ2t7NGCUAnz9P/icons.css" rel="stylesheet">
    </head>
		<body>
		<div class="row">
			<div class="large-12 columns">
			<?php
			    
			    $con=mysqli_connect("localhost","root","root","kangu-product");
				if (mysqli_connect_errno()) {
					echo "Failed to connect to MySQL: " . mysqli_connect_error();
				}
				mysqli_select_db($con,"test");

				if(!empty($_GET))
				{

				    $school = $_GET['school'];
				    $price = $_GET['price']; 
				    $children = $_GET['number-children'];
				     
				    $min_length = 1;
				     
				    if(strlen($school) >= $min_length) {
				         
				        $school = htmlspecialchars($school); 
				        $price = htmlspecialchars($price);
				        $school = mysqli_real_escape_string($con, $school);
				        
				        $raw_results = mysqli_query($con, "SELECT * FROM tbl_advert LEFT JOIN tbl_user ON tbl_advert.fk_user_id=tbl_user.user_id WHERE advert_school LIKE '%".$school."%' AND advert_price <= $price AND advert_spots >= $children");
				         
				        if(mysqli_num_rows($raw_results) > 0) {
				            while($results = mysqli_fetch_array($raw_results)) {

				            	$shorten = strpos($results['advert_description'], ' ', 145);
								$final_advert_description = substr($results['advert_description'], 0, $shorten)." ...";

					            echo "<div class='advert-container end'>
			    					  	<a href='advert-detail.php?id=".$results['advert_id']."' class='advert-link'>
			    							<div class='advert'>
								    			<div class='small-12 columns'>
									    			<div class='small-2 columns'>
									    				<img class='advert-profile-image' src='".$results['user_image_path']."'>
									    			</div>
									    			
									    			<div class='small-10 columns'>
										    			<ul class='advert-information-list'>
										    				<li>".$results['user_firstname'].' '.$results['user_lastname']."</li>
										    				<li data-icon='d'>".$results['user_city']."</li>
										    			</ul>
									    			</div>
								    			</div>

				    							<p class='advert-description'>".$final_advert_description."</p>
				    			
								    			<div class='small-6 columns'>
									    			<div class='advert-price'>
										    			<p>".$results['advert_price']."</p>
										    			<p>p/u</p>
									    			</div>
									    		</div>

									    		<div class='small-6 columns'>
									    			<div class='advert-spots'>
									    				<p>".$results['advert_spots']."</p>
										    			<p>plaatsen</p>
									    			</div>
									    		</div>
						    	
									    		<p class='advert-school' data-icon='e'>Basisschool ".$results['advert_school']."</p>
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
			</div>
		</div>
		</body>
</html>