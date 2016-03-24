<?php

include("../php-assets/class.dbconfig.php");
			    
$con = mysqli_connect("localhost","root","root","kangu-product");

if (mysqli_connect_errno()) {
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

mysqli_select_db($con,"test");

if(!empty($_GET)) {
    $school = htmlspecialchars($_GET['school']); 
    $price = htmlspecialchars($_GET['price']);
    $children = htmlspecialchars($_GET['number-children']);
    
    $raw_results = mysqli_query($con, "SELECT * FROM tbl_advert LEFT JOIN tbl_user ON tbl_advert.fk_user_id=tbl_user.user_id WHERE advert_school LIKE '%".$school."%' AND advert_price <= '".$price."' AND advert_spots >= '".$spots."'");
     
    $number_results = mysqli_num_rows($raw_results);

    if($number_results > 0) {
		echo "<div class='large-12 columns'>
				    <div class='large-10 columns'>
				    	<h2>".$number_results." gevonden advertenties</h2>
				    	<hr class='blue-horizontal-line'></hr>
				    </div>

				    <div class='large-2 columns'>
				    	<form action='advert-overview.php' method='post'>
							<select class='advert-overview-filter' name='advert-overview-filter' onchange='this.form.submit()'>
								<option selected='selected'>Filter advertenties</option>
								<option value='recent'>Meest recent</option>
								<option value='popular'>Meest populair</option>
								<option value='descending'>Prijs hoog - laag</option>
								<option value='ascending'>Prijs laag - hoog</option>
							</select>
						</form>
				    </div>
				</div>

				<div class='large-12 columns'>";

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
			        echo "<div class='no-search-results-container'><p>Er zijn geen advertenties gevonden</p></div>";
			    }
		echo "</div>";
} 
?>